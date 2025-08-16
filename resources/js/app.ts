import { createApp } from "vue";
import Departments from "./components/DepartmentList.vue";
import Home from "./pages/Home.vue";
import "../css/app.css";

const app = createApp({
    components: {
        Home,
    },
    template: `
      <Home />
    `
});

app.mount("#app");