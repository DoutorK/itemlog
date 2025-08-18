<template>
  <div class="department-card department-card-clickable" @click="openModal">
    <div class="card-header">
      <template v-if="!editing">
        <h3>{{ department.name }}</h3>
      </template>
      <template v-else>
        <input v-model="editName" class="edit-input" @click.stop @keyup.enter="saveEdit" @blur="cancelEdit" />
        <button class="save-btn" @click.stop="saveEdit">Salvar</button>
      </template>
      <div class="card-actions">
        <button class="dots-btn" @click.stop="toggleMenu">⋯</button>
        <div v-if="menuOpen && !editing" class="item-menu">
          <button class="item-menu-btn" @click.stop="startEdit">Editar</button>
          <button class="item-menu-btn delete" @click.stop="deleteDepartment">Excluir</button>
        </div>
      </div>
    </div>
    <DepartmentItemsModal
      v-if="showModal"
      :show="showModal"
      :department="department"
      :onClose="closeModal"
      @updated="emit('updated')"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { api } from "../services/api";
import DepartmentItemsModal from "../components/DepartmentItemsModal.vue";
import "../styles/departmentcard.css";

const props = defineProps<{ department: { id: number; name: string } }>();
const emit = defineEmits(["updated"]);

const showModal = ref(false);
const menuOpen = ref(false);
const editing = ref(false);
const editName = ref(props.department.name);

function openModal() {
  showModal.value = true;
}
function closeModal() {
  showModal.value = false;
}

function toggleMenu() {
  menuOpen.value = !menuOpen.value;
}
function closeMenu() {
  menuOpen.value = false;
}

async function deleteDepartment() {
  closeMenu();
  if (!confirm("Tem certeza que deseja excluir este departamento?")) return;
  await api.delete(`/departments/${props.department.id}`);
  emit("updated");
}

function startEdit() {
  closeMenu();
  editName.value = props.department.name;
  editing.value = true;
}
function cancelEdit() {
  editing.value = false;
}
async function saveEdit() {
  if (editName.value.trim() && editName.value !== props.department.name) {
    await api.put(`/departments/${props.department.id}`, { name: editName.value });
    emit("updated");
  }
  editing.value = false;
}

</script>
