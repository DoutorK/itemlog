<template>
  <div class="container">
    <h2>Items</h2>
    <input v-model="newItem" placeholder="Novo item" />
    <button @click="addItem">Adicionar</button>

    <ul>
      <li v-for="item in items" :key="item.id">{{ item.name }}</li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { api } from "../services/api";
import "../styles/items.css";

const items = ref<{ id: number; name: string }[]>([]);
const newItem = ref("");

async function fetchItems() {
  const res = await api.get("/items");
  items.value = res.data;
}

async function addItem() {
  if (!newItem.value) return;
  await api.post("/items", { name: newItem.value });
  newItem.value = "";
  fetchItems();
}

onMounted(fetchItems);
</script>

