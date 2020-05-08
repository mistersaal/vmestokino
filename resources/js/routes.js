import Welcome from "./views/Welcome/index";
import Menu from "./views/Menu/index";

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
