<template>
  <div class="items-container">
    <h4>Itens do Departamento {{ departmentId }}</h4>

    <div class="add-item">
      <input v-model="newItem" placeholder="Novo item" class="input-field" />
      <button @click="addItem" class="add-btn">Adicionar</button>
    </div>

    <ul class="item-list">
      <li v-for="item in items" :key="item.id" class="item">
        {{ item.name }}
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, watch } from "vue";
import { api } from "../services/api";

const props = defineProps<{ departmentId: number }>();
const items = ref<{ id: number; name: string }[]>([]);
const newItem = ref("");

// Busca itens do departamento
async function fetchItems() {
  const res = await api.get(`/departments/${props.departmentId}/items`);
  items.value = res.data;
}

// Adiciona item ao departamento
async function addItem() {
  if (!newItem.value.trim()) return;
  await api.post(`/departments/${props.departmentId}/items`, { name: newItem.value });
  newItem.value = "";
  fetchItems();
}

// Atualiza itens quando departmentId muda
watch(() => props.departmentId, fetchItems);

onMounted(fetchItems);
</script>
