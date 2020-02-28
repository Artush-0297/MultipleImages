import Images from "../components/Images/Images";
import Insert from "../components/Insert/Insert";

const routes = [
    {
        exact: true,
        path: "/",
        component: Images,
    },
    {
        exact: true,
        path: "/insert",
        component: Insert,
    }
];

export default routes;
