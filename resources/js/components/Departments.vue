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
        <span v-if="editId !== dept.id">{{ dept.name }}</span>

        <!-- Campo de edição -->
        <input 
          v-else
          v-model="editName"
          class="input-field edit-input"
        />

        <div class="action-buttons">
          <!-- Botão para adicionar item -->
          <button class="item-btn" title="Adicionar item">
            +
          </button>

          <!-- Botões de edição e exclusão -->
          <button 
            v-if="editId !== dept.id" 
            class="edit-btn"
            title="Editar"
            @click="startEdit(dept)"
          >
            ✏️
          </button>
          <button 
            v-else
            class="save-btn"
            title="Salvar"
            @click="saveEdit(dept.id)"
          >
            💾
          </button>

          <button 
            class="delete-btn"
            title="Excluir"
            @click="deleteDepartment(dept.id)"
          >
            🗑️
          </button>
        </div>
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

// Controle de edição
const editId = ref<number | null>(null);
const editName = ref("");

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

onMounted(fetchDepartments);
</script>
