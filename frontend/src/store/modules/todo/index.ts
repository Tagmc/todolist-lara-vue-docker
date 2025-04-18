import Module from "vuex";
import type { Todo, TodoState, RootState } from "./types";
import {
  fetchTodos,
  createTodo,
  updateTodo,
  deleteTodo,
} from "../../apis/todoApi";

type TodoGetters = {
  completedTodos: (state: TodoState) => Todo[];
  activeTodosCount: (state: TodoState) => number;
  isLoading: (state: TodoState) => boolean;
  highPriorityTodos: (state: TodoState) => Todo[];
};

type TodoActionContext = {
  commit: Function;
  dispatch: Function;
  state: TodoState;
  getters: TodoGetters;
  rootState: RootState;
};

const todoModule: Module<TodoState, RootState> = {
  namespaced: true,
  state: () => ({
    todos: [],
    loading: false,
    filterPriority: null,
  }),

  getters: {
    completedTodos: (state: TodoState) =>
      state.todos.filter((t) => t.completed),
    activeTodosCount: (state: TodoState) =>
      state.todos.filter((t) => !t.completed).length,
    isLoading: (state: TodoState) => state.loading,
    highPriorityTodos: (state: TodoState) =>
      state.todos.filter((t) => t.priority === 3),
  },

  mutations: {
    SET_TODOS(state: TodoState, todos: Todo[]) {
      state.todos = todos;
      console.log(state.todos);
    },
    ADD_TODO(state: TodoState, todo: Todo) {
      state.todos.push(todo);
    },
    UPDATE_TODO(state: TodoState, updated: Todo) {
      const index = state.todos.findIndex((t) => t.id === updated.id);
      if (index !== -1) state.todos[index] = updated;
    },
    DELETE_TODO(state: TodoState, id: number) {
      state.todos = state.todos.filter((t) => t.id !== id);
    },
    SET_LOADING(state: TodoState, value: boolean) {
      state.loading = value;
    },
    SET_PRIORITY_FILTER(state: TodoState, priority: number | null) {
      state.filterPriority = priority;
    },
  },

  actions: {
    async fetchTodos({ commit, state }: TodoActionContext) {
      commit("SET_LOADING", true);
      const response = await fetchTodos(state.filterPriority || undefined);
      const todos: Todo[] = response.data;
      commit("SET_TODOS", todos);
      commit("SET_LOADING", false);
    },

    async addTodo(
      { commit }: TodoActionContext,
      payload: { title: string; priority: number }
    ) {
      commit("SET_LOADING", true);
      const response = await createTodo(payload.title, payload.priority);
      commit("ADD_TODO", response.data);
      commit("SET_LOADING", false);
    },

    async toggleTodo({ commit }: TodoActionContext, todo: Todo) {
      const updated = { ...todo, completed: !todo.completed };
      const response = await updateTodo(updated);
      commit("UPDATE_TODO", response.data);
    },

    async deleteTodo({ commit }: TodoActionContext, todo: Todo) {
      await deleteTodo(todo);
      commit("DELETE_TODO", todo.id);
    },

    setPriorityFilter(
      { commit, dispatch }: TodoActionContext,
      priority: number | null
    ) {
      commit("SET_PRIORITY_FILTER", priority);
      dispatch("fetchTodos");
    },
  },
};

export default todoModule;
