/* eslint-disable import/order */
import '@/@iconify/icons-bundle'
import App from '@/App.vue'
import vuetify from '@/plugins/vuetify'
import { loadFonts } from '@/plugins/webfontloader'
import router from '@/router'

import '@/styles/styles.scss'
import '@core/scss/index.scss'
import 'vue-toast-notification/dist/theme-sugar.css'

import { createPinia } from 'pinia'
import { createApp } from 'vue'

loadFonts()

// // GOOD
// const token=localStorage.getItem("token")
// router.beforeEach(async (to, from) => {
//   if (
//     // make sure the user is authenticated
//     !token &&
//     // ❗️ Avoid an infinite redirect
//     to.name !== 'login'
//   ) {
//     // redirect the user to the login page
//     return { name: 'login' }
//   }
// })

const app = createApp(App)

app.use(vuetify)
app.use(createPinia())
app.use(router)
app.mount('#app')
