<template>
  <teleport to="body">
    <div v-if="show" class="modal-overlay" @click.self="close">
      <div class="modal-content">
        <h2 class="modal-title">Itens de {{ department.name }}</h2>
        <div class="modal-actions">
          <input v-model="newItem" placeholder="Novo item" class="modal-input" />
          <button @click="addItem" class="modal-btn">Adicionar</button>
        </div>
        <div v-if="loading" class="modal-loading">
          <span class="spinner"></span>
          <span>Carregando itens...</span>
        </div>
        <ul v-else class="modal-list">
          <li v-for="item in items" :key="item.id" class="modal-item">
            <template v-if="editingItem !== item.id">
              <span>{{ item.name }}</span>
            </template>
            <template v-else>
              <input v-model="editItemName" class="edit-input" @click.stop @keyup.enter="saveEditItem(item)" @blur="cancelEditItem" />
              <button class="save-btn" @click.stop="saveEditItem(item)">Salvar</button>
            </template>
            <div class="modal-item-actions">
              <button class="dots-btn" v-if="editingItem !== item.id" @click="toggleMenu(item.id)">⋯</button>
              <div v-if="menuOpen === item.id && editingItem !== item.id" class="item-menu">
                <button class="item-menu-btn" @click="startEditItem(item)">Editar</button>
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
const editingItem = ref<number|null>(null);
const editItemName = ref("");
const loading = ref(false);

function close() {
  if (typeof props.onClose === 'function') props.onClose();
}

function toggleMenu(id: number) {
  menuOpen.value = menuOpen.value === id ? null : id;
}
function closeMenu() {
  menuOpen.value = null;
}

function startEditItem(item: { id: number; name: string }) {
  closeMenu();
  editingItem.value = item.id;
  editItemName.value = item.name;
}
function cancelEditItem() {
  editingItem.value = null;
}
async function saveEditItem(item: { id: number; name: string }) {
  if (editItemName.value.trim() && editItemName.value !== item.name) {
    await api.put(`/items/${item.id}`, { name: editItemName.value, department_id: props.department.id });
    fetchItems();
  }
  editingItem.value = null;
}

async function fetchItems() {
  if (!props.department) return;
  loading.value = true;
  try {
    const res = await api.get(`/departments/${props.department.id}/items`);
    items.value = res.data;
  } finally {
    loading.value = false;
  }
}

async function addItem() {
  if (!newItem.value.trim()) return;
  await api.post(`/departments/${props.department.id}/items`, { name: newItem.value });
  newItem.value = "";
  fetchItems();
}

async function deleteItem(id: number) {
  if (!confirm("Excluir item?")) return;
  await api.delete(`/items/${id}`);
  fetchItems();
}

watch(() => props.department, fetchItems);
onMounted(fetchItems);
</script>

