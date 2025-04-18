<template>
  <div class="max-w-xl mx-auto p-6 bg-white shadow rounded mt-10">
    <h1 class="text-2xl font-bold mb-4">📋 Todo List ấdsadasd</h1>
    <div v-if="isLoading" class="text-center my-4">
      <div class="spinner"></div>
    </div>
    <div v-else class="flex gap-2 mb-4">
      <input
        v-model="newTitle"
        @keyup.enter="addTodo"
        placeholder="Add new todo..."
        class="flex-1 p-2 border rounded"
      />
      <select v-model.number="newPriority" class="p-2 border rounded">
        <option :value="1">Low</option>
        <option :value="2">Medium</option>
        <option :value="3">High</option>
      </select>
      <button @click="addTodo" class="bg-blue-500 text-white px-4 rounded">
        Add
      </button>
    </div>

    <div class="mb-4">
      <label class="mr-2">Filter by Priority:</label>
      <select
        v-model.number="priorityFilter"
        @change="filterByPriority"
        class="border p-2 rounded"
      >
        <option :value="null">All</option>
        <option :value="1">Low</option>
        <option :value="2">Medium</option>
        <option :value="3">High</option>
      </select>
    </div>

    <ul>
      <li
        v-for="todo in todos"
        :key="todo.id"
        class="flex justify-between items-center py-2 border-b"
      >
        <label class="flex items-center gap-2">
          <input
            type="checkbox"
            :checked="todo.completed"
            @change="toggle(todo)"
          />
          <span :class="{ 'line-through text-gray-400': todo.completed }">
            [{{ todo.priority }}] {{ todo.title }}
          </span>
        </label>
        <button @click="remove(todo)" class="text-red-500 hover:underline">
          ❌
        </button>
      </li>
    </ul>

    <p class="mt-4 text-gray-600">Active Todos: {{ activeCount }}</p>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted } from "vue";
import { useStore } from "vuex";
import type { Todo } from "./store/modules/todo/types";

const store = useStore();
const newTitle = ref("");
const newPriority = ref(1);
const priorityFilter = ref<number | null>(null);
const isLoading = computed(() => store.getters["todo/isLoading"]);
const todos = computed(() => store.state.todo.todos);
const activeCount = computed(() => store.getters["todo/activeTodosCount"]);

const fetch = () => store.dispatch("todo/fetchTodos");
const addTodo = () => {
  if (newTitle.value.trim()) {
    store.dispatch("todo/addTodo", {
      title: newTitle.value,
      priority: newPriority.value,
    });
    newTitle.value = "";
    newPriority.value = 1;
  }
};
const toggle = (todo: Todo) => store.dispatch("todo/toggleTodo", todo);
const remove = (todo: Todo) => store.dispatch("todo/deleteTodo", todo);
const filterByPriority = () =>
  store.dispatch("todo/setPriorityFilter", priorityFilter.value);

onMounted(fetch);
</script>
