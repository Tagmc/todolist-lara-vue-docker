import workApi from "../../axios";
import type { Todo } from "../modules/todo/types";

export const fetchTodos = (priority?: number) =>
  workApi.get<Todo[]>("/todos", { params: priority ? { priority } : {} });
export const createTodo = (title: string, priority = 1) =>
  workApi.post<Todo>("/todos", { title, priority });
export const updateTodo = (todo: Todo) =>
  workApi.put<Todo>(`/todos/${todo.id}`, todo);
export const deleteTodo = (todo: Todo) =>
  workApi.delete(`/todos/${todo.id}`);

