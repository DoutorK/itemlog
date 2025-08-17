<template>
  <div class="department-card department-card-clickable" @click="openModal">
    <div class="card-header">
      <h3>{{ department.name }}</h3>
      <div class="card-actions">
        <button class="dots-btn" @click.stop="toggleMenu">⋯</button>
        <div v-if="menuOpen" class="item-menu">
          <button class="item-menu-btn" @click.stop="editDepartment">Editar</button>
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

function editDepartment() {
  closeMenu();
  const novoNome = prompt("Editar nome do departamento:", props.department.name);
  if (novoNome && novoNome.trim() && novoNome !== props.department.name) {
    api.put(`/departments/${props.department.id}`, { name: novoNome }).then(() => emit("updated"));
  }
}

</script>
