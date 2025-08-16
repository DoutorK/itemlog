<template>
  <div class="department-card">
    <div class="card-header">
      <h3>{{ department.name }}</h3>
      <div class="card-actions">
        <button class="delete-btn" @click="deleteDepartment">🗑️</button>
        <button class="toggle-btn" @click="toggleItems">
          {{ showItems ? "Fechar" : "Ver Itens" }}
        </button>
      </div>
    </div>

    <!-- Lista de itens -->
    <transition name="fade">
      <ItemsList 
        v-if="showItems" 
        :department-id="department.id" 
      />
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { api } from "../services/api";
import ItemsList from "../components/ItemsList.vue"
import "../styles/departmentcard.css";

const props = defineProps<{ department: { id: number; name: string } }>();
const emit = defineEmits(["updated"]);

const showItems = ref(false);

function toggleItems() {
  showItems.value = !showItems.value;
}

async function deleteDepartment() {
  if (!confirm("Tem certeza que deseja excluir este departamento?")) return;
  await api.delete(`/departments/${props.department.id}`);
  emit("updated");
}

</script>
