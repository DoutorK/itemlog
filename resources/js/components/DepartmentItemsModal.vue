<template>
  <teleport to="body">
    <div v-if="show" class="modal-overlay" @click.self="close">
      <div class="modal-content">
        <h2 class="modal-title">Itens de {{ department.name }}</h2>
        <div class="modal-actions">
          <input v-model="newItem" placeholder="Novo item" class="modal-input" />
          <button @click="addItem" class="modal-btn">Adicionar</button>
        </div>
        <ul class="modal-list">
          <li v-for="item in items" :key="item.id" class="modal-item">
            <span>{{ item.name }}</span>
            <div class="modal-item-actions">
              <button class="dots-btn" @click="toggleMenu(item.id)">⋯</button>
              <div v-if="menuOpen === item.id" class="item-menu">
                <button class="item-menu-btn" @click="editItem(item); closeMenu()">Editar</button>
                <button class="item-menu-btn delete" @click="deleteItem(item.id); closeMenu()">Excluir</button>
              </div>
            </div>
          </li>
        </ul>
        <button class="modal-close" @click="close">Fechar</button>
      </div>
    </div>
  </teleport>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from "vue";
import { api } from "../services/api";
import "../styles/modal.css";

const props = defineProps<{ show: boolean; department: { id: number; name: string }; onClose: () => void }>();
const emit = defineEmits(["updated"]);

const items = ref<{ id: number; name: string }[]>([]);
const newItem = ref("");
const menuOpen = ref<number|null>(null);

function close() {
  if (typeof props.onClose === 'function') props.onClose();
}

function toggleMenu(id: number) {
  menuOpen.value = menuOpen.value === id ? null : id;
}
function closeMenu() {
  menuOpen.value = null;
}

async function fetchItems() {
  if (!props.department) return;
  const res = await api.get(`/departments/${props.department.id}/items`);
  items.value = res.data;
}

async function addItem() {
  if (!newItem.value.trim()) return;
  await api.post(`/departments/${props.department.id}/items`, { name: newItem.value });
  newItem.value = "";
  fetchItems();
}

async function deleteItem(id: number) {
  if (!confirm("Excluir item?")) return;
  await api.delete(`/departments/${props.department.id}/items/${id}`);
  fetchItems();
}

function editItem(item: { id: number; name: string }) {
  const novoNome = prompt("Editar nome do item:", item.name);
  if (novoNome && novoNome.trim() && novoNome !== item.name) {
    api.put(`/departments/${props.department.id}/items/${item.id}`, { name: novoNome }).then(fetchItems);
  }
}

watch(() => props.department, fetchItems);
onMounted(fetchItems);
</script>

