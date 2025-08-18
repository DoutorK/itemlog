<template>
  <div class="items-container">
    <div class="add-item">
      <input v-model="newItem" placeholder="Novo item" class="input-field" />
      <button @click="addItem" class="add-btn">Adicionar</button>
    </div>

    <ul class="item-list">
      <li v-for="item in items" :key="item.id" class="item">
        <span>{{ item.name }}</span>
        <button class="delete-btn" @click="deleteItem(item.id)">🗑️</button>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from "vue";
import { api } from "../services/api";
import "../styles/itemslist.css";

const props = defineProps<{ departmentId: number }>();

const items = ref<{ id: number; name: string }[]>([]);
const newItem = ref("");

async function fetchItems() {
  const res = await api.get(`/departments/${props.departmentId}/items`);
  items.value = res.data;
}

async function addItem() {
  if (!newItem.value.trim()) return;
  await api.post(`/departments/${props.departmentId}/items`, { name: newItem.value });
  newItem.value = "";
  fetchItems();
}

async function deleteItem(id: number) {
  if (!confirm("Excluir item?")) return;
  await api.delete(`/departments/${props.departmentId}/items/${id}`);
  fetchItems();
}

watch(() => props.departmentId, fetchItems);
onMounted(fetchItems);
</script>
