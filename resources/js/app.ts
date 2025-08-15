import { createApp } from "vue";
import Departments from "../js/components/Departments.vue";
import "../css/app.css";

const app = createApp({
    components: {
        Departments,
    },
    template: `
      <Departments />
    `
});

app.mount("#app");