import { createStore } from "vuex";
import todo from "./modules/todo";
import type { RootState } from "./modules/todo/types";

export default createStore<RootState>({
  modules: {
    todo,
  },
});

