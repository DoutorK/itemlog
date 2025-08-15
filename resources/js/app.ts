import { createApp } from "vue";
import Departments from "../js/components/Departments.vue";
import Items from "./components/Items.vue";
import "../css/app.css";

const app = createApp({
    components: {
        Departments,
        Items
    },
    template: `
      <Departments />
      <Items />
    `
});

app.mount("#app");