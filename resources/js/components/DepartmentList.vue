<template>
  <div>
    <!-- Adicionar novo departamento -->
    <div class="add-department">
      <input v-model="newDepartment" placeholder="Novo departamento" class="input-field" />
      <button @click="addDepartment" class="add-btn">Adicionar</button>
    </div>

    <!-- Lista de departamentos -->
    <div class="departments-grid">
      <DepartmentCard 
        v-for="dept in departments" 
        :key="dept.id" 
        :department="dept"
        @updated="fetchDepartments"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { api } from "../services/api";
import DepartmentCard from "./DepartmentCard.vue";
import "../styles/departmentlist.css";

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