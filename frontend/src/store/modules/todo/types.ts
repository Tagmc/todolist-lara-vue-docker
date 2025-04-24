export interface Todo {
  id: number;
  title: string;
  completed: boolean;
  priority: number;
  status: string;
  deadline: string | null;
}

export interface TodoState {
  todos: Todo[];
  loading: boolean;
  filterPriority: number | null;
  statusFilter: 'all' | 'doing' | 'done';
}

export interface RootState {
  todo: TodoState;
}