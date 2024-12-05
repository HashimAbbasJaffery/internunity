<template>
  <header class="bg-base text-white py-4">
    <div class="container mx-auto w-2/3 flex justify-between items-center">
      <div class="logo">
        <h1 class="text-3xl font-bold">Internunity</h1>
      </div>
      <nav>
        <ul class="flex items-center space-x-2">
          <li
            class="px-3 rounded py-1"
            :class="{ 'bg-shade text-black': $route.name === 'home' }"
          >
            <RouterLink to="/">Apply</RouterLink>
          </li>
          <li
            class="hover:bg-shade hover:text-black px-3 py-1 rounded"
            :class="{ 'bg-shade text-black': $route.name === 'applications' }"
          >
            <RouterLink to="/applications">Internships</RouterLink>
          </li>
          <li
            class="hover:bg-shade hover:text-black px-3 py-1 rounded"
            :class="{ 'bg-shade text-black': $route.name === 'profile' }"
          >
            <RouterLink to="/profile">Profile</RouterLink>
          </li>
          <li
            v-if="isLoggedin"
            class="hover:bg-shade hover:text-black px-3 py-1 rounded"
            @click="logout"
          >
            Logout
          </li>
          <li v-else class="hover:bg-shade hover:text-black px-3 py-1 rounded">
            <RouterLink to="/login">Login</RouterLink>
          </li>
          <li
            class="hover:bg-shade hover:text-black px-3 py-1 rounded relative w-full"
            @click="readNotification"
          >
            <div
              v-if="has_notification"
              class="has-notifications bg-base-alt rounded-full absolute right-2 top-1 animate__animated"
              style="width: 10px; height: 10px"
            >
              &nbsp;
            </div>
            <i class="fa-solid fa-bell animate__animated"></i>
            <div
              v-if="show_all_notifications"
              class="notification-list absolute bg-white text-black rounded z-20 shade mt-4"
              style="width: 300px; max-height: 300px; overflow: auto; right: 0px"
            >
              <ul
                class="space-y-3 w-full"
                v-for="notification in notificationsList"
                :key="notification.id"
                @click="console.log(notification)"
              >
                <message-notification
                  @click="show_chat(notification, false)"
                  @read="console.log($event)"
                  :notification="notification"
                ></message-notification>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="fixed bottom-0 right-0 z-20 w-full flex flex-row-reverse gap-2 items-end">
    <chat-box
      :rooms="chat_rooms"
      :message_notifications="message_notifications"
    ></chat-box>
    <chat-instance
      v-for="chat in chats.slice(0, 3)"
      @deleteChat="deleteChat"
      :chat="chat"
      :key="chat.id"
    ></chat-instance>
    <hidden-chats :chats="chats.slice(3)" v-if="chats.length > 3"></hidden-chats>
  </div>
  <slot></slot>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { useRouter } from "vue-router";
import { computed, onMounted, onUnmounted, provide, ref, watch } from "vue";
import axios from "axios";
import ChatBox from "../Utils/ChatBox.vue";
import ChatInstance from "../Utils/ChatInstance.vue";
import HiddenChats from "../Utils/HiddenChats.vue";
import MessageNotification from "../Utils/MessageNotification.vue";
import Notifications from "../../Classes/Notifications";

const router = useRouter();
const isLoggedin = ref(localStorage.getItem("token")?.length ?? false);
const has_notification = ref(false);
const notification_icon = ref(false);
const notification_sender = ref("");
const notificationsList = ref([]);
const show_all_notifications = ref(false);
const chat_rooms = ref([]);
const chats = ref([]);
provide("chats", chats);

const removeAllUserItems = () => {
  has_notification.value = false;
  notificationsList.value = [];
  show_all_notifications.value = false;
  chat_rooms.value = [];
  chats.value = [];
};

const readNotification = async () => {
  show_all_notifications.value = !show_all_notifications.value;
  has_notification.value = false;
  const status = await axios.post("/api/notifications/user", { _method: "PUT" });
  console.log(status.data);
};

// const has_page_loaded = ref(false);

const message_notifications = computed(() =>
  notificationsList.value.filter(
    (notification) => notification.data?.extras?.type === "message"
  )
);

const logout = async () => {
  let config = {
    headers: {
      Authorization: "Bearer " + localStorage.token,
    },
  };
  const user = await axios.get("/api/user", config);

  unsubscribeToChannel(`App.Models.User.${user.data?.id ?? false}`, true);
  const status = await axios.delete("/api/logout");
  if (status.data) {
    localStorage.removeItem("token");
    router.push("/");
    isLoggedin.value = false;

    removeAllUserItems();
  }
};

const add_new_chat = (notification, index) => {
  notification.extras.room.chats = JSON.parse(notification.extras.room.chats);
  chat_rooms.value.push(notification.extras.room);
  index = chat_rooms.value.length - 1;
  return index;
};

const show_chat = (notification, append_message = true) => {
  // Getting Index of the list of companies in the ChatBox
  // if index >= 0 means company has already chatted before

  let index = chat_rooms.value.findIndex((chat_room) => {
    return (
      parseInt(chat_room.company_id) ===
        parseInt(
          notification?.extras?.company_id ?? notification?.data?.extras?.company_id
        ) &&
      parseInt(chat_room.user_id) ===
        parseInt(notification?.extras?.user_id ?? notification?.data?.extras?.user_id)
    );
  });

  // This check indicates that the company is messaging first time
  if (index < 0) {
    index = add_new_chat(notification, index);
  }

  append_message &&
    chat_rooms.value[index].chats.push({
      message: notification.message,
      from: "company",
    });
  chat_rooms.value[index].is_read = false;

  !chats.value.filter((chat) => chat.id === chat_rooms.value[index].id).length &&
    chats.value.push(chat_rooms.value[index]);
};

const subscribeToChannel = (channel) => {
  window.Echo.private(channel).notification((notification) => {
    // Checking if notification is about MESSAGE OF USER FROM CHAT
    if (notification.type === "broadcast.message") {
      notification_sender.value = notification.extras?.sender_name;

      // Adding proxy data to show the number in realtime
      notificationsList.value.push({ data: { extras: { type: "message" } } });

      show_chat(notification);
    }

    // Making notification toast visible with content
    notification_icon.value = true;
    has_notification.value = true;

    console.log("Notification");
    console.log(notification);
    notificationsList.value.push(notification);
  });
};

const unsubscribeToChannel = (channel, is_private) => {
  channel = `${is_private ? "private-" : ""}${channel}`;
  window.Echo.leaveChannel(channel);
};

onMounted(async () => {
  const status = await axios.get("/api/user");
  has_notification.value = status.data.has_notifications;
  chat_rooms.value = status.data.chat_rooms;
  const notifications = await axios.get("/api/notifications");
  if (notifications.data?.length) {
    notification_icon.value = true;
    notificationsList.value = notifications.data;
  }
  // Realtime notifications
  if (localStorage.token)
    subscribeToChannel(`App.Models.User.${status.data?.id ?? false}`);

  //   has_page_loaded.value = true;
});

// Watcher to hide the notification after exactly 5 seconds

const deleteChat = (id) => {
  chats.value = chats.value.filter((chat) => chat.id !== id);
};
</script>
