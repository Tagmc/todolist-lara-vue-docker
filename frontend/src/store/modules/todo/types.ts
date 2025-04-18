export interface Todo {
  id: number;
  title: string;
  completed: boolean;
  priority: number;
}

export interface TodoState {
  todos: Todo[];
  loading: boolean;
  filterPriority: number | null;
}

export interface RootState {
  todo: TodoState;
}