import Welcome from "./views/Welcome/index";
import Menu from "./views/Menu/index";
import Room from "./views/Room/index";

export default [
    {
        path: '/welcome',
        // component: Welcome,
        redirect: '/' //TODO
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
    },
    {
        path: '/*',
        redirect: to => {
            if (/\/[0-9]+_.{8}/.test(to.fullPath)) {
                return {
                    path: '/room' + to.fullPath.split('_')[0],
                    query: {
                        password: to.fullPath.split('_')[1]
                    }
                }
            }
            return '/';
        }
    }
];
