import MainContent from './../components/MainContent.vue'
import Pdp from './../pages/Pdp'
import Login from './../pages/Login'
import Signup from './../pages/Signup'
import AboutUs from './../pages/About'
import ContactUs from './../pages/Contact'

export const routes  = [
    {
        path: '/',
        name: 'home',
        component: MainContent
    },
    {
        path: '/product/id/:id',
        name: 'product',
        component: Pdp
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/signup',
        name: 'signup',
        component: Signup
    },
    {
        path: '/about',
        name: 'about',
        component: AboutUs
    },
    {
        path: '/contact-us',
        name: 'contact',
        component: ContactUs
    }
]