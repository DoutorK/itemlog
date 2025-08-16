<template>
  <div class="departments-container">
    <h2 class="title">Departments</h2>

    <!-- Adicionar departamento -->
    <div class="add-department">
      <input v-model="newDepartment" placeholder="Novo departamento" class="input-field" />
      <button @click="addDepartment" class="add-btn">Adicionar</button>
    </div>

    <!-- Lista de departamentos -->
    <ul class="department-list">
      <li v-for="dept in departments" :key="dept.id" class="department-item">
        <span v-if="editId !== dept.id">{{ dept.name }}</span>
        <input v-else v-model="editName" class="input-field edit-input" />

        <div class="action-buttons">
          <!-- Botão para abrir itens -->
          <button class="item-btn" @click="toggleItems(dept.id)">+</button>

          <!-- Botões de editar/salvar -->
          <button v-if="editId !== dept.id" class="edit-btn" @click="startEdit(dept)">✏️</button>
          <button v-else class="save-btn" @click="saveEdit(dept.id)">💾</button>

          <!-- Botão de deletar -->
          <button class="delete-btn" @click="deleteDepartment(dept.id)">🗑️</button>
        </div>

        <!-- Componente Items exibido abaixo do departamento -->
        <Items 
          v-if="activeDeptId === dept.id" 
          :department-id="dept.id" 
          class="items-component"
        />
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { api } from "../services/api";
import Items from "./Items.vue";
import "../styles/departments.css";

const departments = ref<{ id: number; name: string }[]>([]);
const newDepartment = ref("");

// Controle de edição
const editId = ref<number | null>(null);
const editName = ref("");

// Departamento ativo para exibir itens
const activeDeptId = ref<number | null>(null);

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

function startEdit(dept: { id: number; name: string }) {
  editId.value = dept.id;
  editName.value = dept.name;
}

async function saveEdit(id: number) {
  if (!editName.value.trim()) return;
  await api.put(`/departments/${id}`, { name: editName.value });
  editId.value = null;
  editName.value = "";
  fetchDepartments();
}

async function deleteDepartment(id: number) {
  if (!confirm("Tem certeza que deseja excluir este departamento?")) return;
  await api.delete(`/departments/${id}`);
  fetchDepartments();
}

// Alterna exibição do Items do departamento clicado
function toggleItems(id: number) {
  activeDeptId.value = activeDeptId.value === id ? null : id;
}

onMounted(fetchDepartments);
</script>
