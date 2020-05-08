import Welcome from "./views/Welcome";
import Menu from "./views/Menu";

export default [
    {
        path: '/welcome',
        component: Welcome
    },
    {
        path: '/',
        component: Menu
    }
];
