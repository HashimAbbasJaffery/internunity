<template>
  <company-layout>
    <section class="messages flex container mx-auto w-2/3 mt-4 gap-2 items-start">
      <div
        class="users options shade text-white w-1/3 p-2 rounded-md space-y-4"
        style="height: 400px; overflow-y: auto"
      >
        <div class="search">
          <input
            type="text"
            id="name"
            class="shade outline-none p-1 px-2 text-black text-sm w-full rounded-md"
            v-model="fields.keyword"
            placeholder="Search"
          />
        </div>
        <user
          class="hover:bg-grey"
          :class="{ 'bg-grey': opened_chat.id === chat.id }"
          v-for="chat in chats.filter((chat) =>
            chat.user?.name.toLowerCase().includes(fields.keyword.toLowerCase())
          )"
          @click="open(chat)"
          :key="chat.id"
          :last_message="chat.chats[chat.chats.length - 1]?.message ?? 'No Chats yet!'"
          :user="chat.user"
        />
      </div>
      <div
        id="chats"
        class="chats flex flex-col h-full shade w-2/3 rounded-md relative"
        style="height: 400px"
      >
        <div
          v-if="!opened_chat.id"
          class="no-opened-chat bg-white absolute w-full h-full z-10 flex flex-col justify-center items-center"
        >
          <i class="fa-solid fa-address-book text-gray-500" style="font-size: 50px"></i>
          <p class="mt-2">Contacts</p>
        </div>
        <div class="chat-header p-2 flex gap-2 border-b-2" style="height: 16%">
          <div class="chat-pic">
            <img
              :src="
                opened_chat.user?.profile_pic
                  ? `/storage/profile/${opened_chat.user.profile_pic}`
                  : 'https://placehold.co/45x45'
              "
              style="height: 45px; width: 45px"
              class="rounded-md"
              alt=""
            />
          </div>
          <div class="user-detail">
            <p class="text-sm">{{ opened_chat.user?.name ?? "No name" }}</p>
            <p class="text-xs italic opacity-75">Online</p>
          </div>
        </div>
        <chat-body :messages="opened_chat.chats"></chat-body>
        <div class="chat-footer p-2 mt-auto flex gap-2" style="height: 14%">
          <form class="w-full flex gap-2" @submit="submitMessage">
            <input
              type="text"
              id="name"
              v-model="fields.message"
              class="shade outline-none p-1 text-sm w-full rounded-md"
              placeholder="Type a message"
            />
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-md">
              <i class="fa-solid fa-paper-plane"></i>
            </button>
          </form>
        </div>
      </div>
    </section>
  </company-layout>
</template>
<script setup>
import CompanyLayout from "../../components/Shared/CompanyLayout.vue";
import User from "../../components/Chat/User.vue";
import Message from "../../components/Chat/Message.vue";
import { onMounted, reactive, ref } from "vue";
import ChatBody from "../../components/Chat/ChatBody.vue";
import { useRoute } from "vue-router";

const chats = ref([]);
const opened_chat = ref([]);
const fields = reactive({
  keyword: "",
  message: "",
});
const route = useRoute();

const chatrooms = async () => {
  const chatrooms = await axios.get("/api/company/chatrooms");
  chats.value = chatrooms.data;
};

const open = (chat) => {
  opened_chat.value = chat;
  console.log(opened_chat.value);
};

// function that return the id of current company via axios request
const currentCompany = async () => {
  const company = await axios.get("/api/company");
  return company.data.id;
};

const submitMessage = async (e) => {
  e.preventDefault();
  let message = fields.message;
  opened_chat.value.chats.push({
    message: fields.message,
    from: "company",
  });
  fields.message = "";
  const response = await axios.post("/api/send", {
    sender: "company",
    user_id: opened_chat.value.user.id,
    company_id: await currentCompany(),
    message: message,
    type: "message",
  });
  if (response.status !== 200) {
    opened_chat.value.chats.pop();
  }
};

const openExistingChat = async () => {
  const chat = chats.value.filter(
    (chat) => parseInt(chat.user_id) === parseInt(route.query.user_id)
  );
  if (chat.length > 0) {
    open(chat[0]);
  } else {
    const user = await axios.get(`/api/company/user/${route.query.user_id}`);
    console.log(user.data);
    console.log(chats.value[0]);
    chats.value.push({
      id: (chats.value[chats.value.length - 1]?.id ?? 0) + 1,
      user: user.data,
      chats: [],
    });
    opened_chat.value = chats.value[chats.value.length - 1];
  }
};

onMounted(async () => {
  await chatrooms();
  route.query?.user_id && openExistingChat();
});
</script>
