import Welcome from "./views/Welcome/index";
import Menu from "./views/Menu/index";
import Room from "./views/Room/index";

export default [
    {
        path: '/welcome',
        component: Welcome
    },
    {
        path: '/',
        component: Menu
    },
    {
        path: '/room',
        component: Room
    },
    {
        path: '/room/:id',
        component: Room
    }
];
