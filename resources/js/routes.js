const routes = [
    {
        path: '/admin',
        name: 'sign-in',
        component: () => import('@views/login'),
        meta: {
            auth: false
        }
    }
];

export default routes;