<template>
  <!-- Modals -->

  <project-modal
    v-if="Object.keys(project ?? [])?.length ?? false"
    :project="project"
    @close="project = []"
    @delete="deleteProject(project.id)"
    @update="update"
  ></project-modal>

  <create-project
    @create="addProject($event)"
    v-if="addModal"
    @close="addModal = false"
    :isLoading="isLoading"
    :errors="errors"
  ></create-project>

  <update-project
    @create="editProject($event)"
    v-if="updateModal"
    @close="updateModal = false"
    :isLoading="isLoading"
    :errors="errors"
    :project="newProject"
  ></update-project>

  <!-- End of Modals -->

  <section
    id="portfolio"
    class="shade p-3 rounded-md"
    :class="{ 'flex justify-center items-center': is_loading }"
  >
    <div class="content" v-if="!is_loading">
      <Heading>Projects</Heading>
      <Button @click="addModal = true">Create</Button>
      <div v-if="internshipsData.length">
        <Projects :internshipsData="internshipsData" @show="project = $event"></Projects>
        <load-more-button
          v-if="next"
          :is_loading="is_loading_more"
          @click="next_page"
          :next="next"
          @next="url = $event"
        ></load-more-button>
      </div>
      <result-not-found v-else>No Project found</result-not-found>
    </div>
    <Loader v-else :is_loading="is_loading" class="loader"></Loader>
  </section>
</template>
<script setup>
import { reactive, ref, inject } from "vue";
import useFetch from "../composables/fetch";
import Loader from "../Utils/Loader.vue";
import usePost from "../composables/post";
import ProjectModal from "../Modals/ProjectModal.vue";
import CreateProject from "../Modals/CreateProject.vue";
import Button from "../Utils/Button.vue";
import Heading from "../Utils/Heading.vue";
import Projects from "../Projects/Projects.vue";
import LoadMoreButton from "../Utils/LoadMoreButton.vue";
import ResultNotFound from "../Utils/ResultNotFound.vue";

const UpdateProject = CreateProject;
const project = ref();
const url = ref(`/api/user/projects`);
const is_global_loading = ref(false);
const postUrl = ref(`/api/user/project/create`);
let { isLoading, sendRequest, errors } = usePost(postUrl);
const addModal = ref(false);
const newProject = reactive({
  title: "",
  youtube: "",
  github: "",
  description: "",
  id: "",
});
const showMenu = ref(false);
const updateModal = ref(false);
const {
  internshipsData,
  is_loading,
  is_loading_more,
  next,
  fetch,
  per_page,
  next_page,
} = inject("projects");

const addProject = (newProject) => {
  postUrl.value = `/api/user/project/create`;
  sendRequest(newProject, function () {
    resetModalsAndRefetch();
    clearAllFields();
  });
};

const resetModalsAndRefetch = () => {
  internshipsData.value = [];
  is_loading.value = true;

  url.value === "/api/user/projects" ? fetch() : (url.value = "/api/user/projects");
  updateModal.value = false;
  showMenu.value = false;
  addModal.value = false;
};

const clearAllFields = () => {
  newProject.title = "";
  newProject.description = "";
  newProject.github = "";
  newProject.youtube = "";
  newProject.id = "";
};

const deleteProject = (id) => {
  postUrl.value = `/api/user/project/${id}/delete`;
  sendRequest({ _method: "delete" }, function () {
    resetModalsAndRefetch();
    project.value = [];
  });
};

const update = () => {
  newProject.title = project.value.title;
  newProject.description = project.value.description;
  newProject.github = project.value.github;
  newProject.youtube = project.value.youtube;
  newProject.id = project.value.id;
  updateModal.value = true;
};

const editProject = (newProject) => {
  postUrl.value = `/api/user/project/${newProject.id}/update`;
  sendRequest({ ...newProject, _method: "PUT" }, function () {
    project.value = [];

    resetModalsAndRefetch();
    clearAllFields();
  });
};
</script>
