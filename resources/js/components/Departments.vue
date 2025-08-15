<template>
  <div class="container">
    <h2>Departments</h2>
    <input v-model="newDepartment" placeholder="Novo departamento" />
    <button @click="addDepartment">Adicionar</button>

    <ul>
      <li v-for="dept in departments" :key="dept.id">{{ dept.name }}</li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { api } from "../services/api";
import '../styles/departments.css';

const departments = ref<{ id: number; name: string }[]>([]);
const newDepartment = ref("");

async function fetchDepartments() {
  const res = await api.get("/departments");
  departments.value = res.data;
}

async function addDepartment() {
  if (!newDepartment.value) return;
  await api.post("/departments", { name: newDepartment.value });
  newDepartment.value = "";
  fetchDepartments();
}

onMounted(fetchDepartments);
</script>
