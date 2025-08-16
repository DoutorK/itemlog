<template>
  <div class="department-card department-card-clickable" @click="openModal">
    <div class="card-header">
      <h3>{{ department.name }}</h3>
      <div class="card-actions">
        <button class="delete-btn" @click.stop="deleteDepartment">🗑️</button>
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

function openModal() {
  showModal.value = true;
}
function closeModal() {
  showModal.value = false;
}

async function deleteDepartment() {
  if (!confirm("Tem certeza que deseja excluir este departamento?")) return;
  await api.delete(`/departments/${props.department.id}`);
  emit("updated");
}

</script>
