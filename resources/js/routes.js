import registerForm from './components/RegisterForm.vue';
import validaForm from './components/ValidateForm.vue';

export const routes = [
    {
        name: 'registrar',
        path: '/:name/registrar',
        component: registerForm
    },
    {
        name: 'validar',
        path: '/:name/validar',
        component: validaForm
    }
];