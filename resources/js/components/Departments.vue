<template>
  <div class="departments-container">
    <h2 class="title">Departments</h2>

    <div class="add-department">
      <input 
        v-model="newDepartment" 
        placeholder="Novo departamento" 
        class="input-field"
      />
      <button @click="addDepartment" class="add-btn">
        Adicionar
      </button>
    </div>

    <ul class="department-list">
      <li 
        v-for="dept in departments" 
        :key="dept.id" 
        class="department-item"
      >
        <span>{{ dept.name }}</span>
        <button class="item-btn">+</button>
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { api } from "../services/api";
import "../styles/departments.css";

const departments = ref<{ id: number; name: string }[]>([]);
const newDepartment = ref("");

async function fetchDepartments() {
  const res = await api.get("/departments");
  departments.value = res.data;
}

async function addDepartment() {
  if (!newDepartment.value.trim()) return;
  await api.post("/departments", { name: newDepartment.value });
  newDepartment.value = "";
  fetchDepartments();
}

onMounted(fetchDepartments);
</script>