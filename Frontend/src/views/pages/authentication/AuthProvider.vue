<script setup lang="ts">
import { defineEmits } from 'vue';
import { useTheme } from 'vuetify';
const vuetifyTheme = useTheme()
const emit=defineEmits("loginWithSocial")
const authProviders = [
  {
    icon: 'mdi-facebook',
    color: '#4267b2',
    colorInDark: '#4267b2',
    // fun:emit("loginWithFacebook")

  },
  // {
  //   icon: 'mdi-twitter',
  //   color: '#1da1f2',
  //   colorInDark: '#1da1f2',
  // },
  // {
  //   icon: 'mdi-github',
  //   color: '#272727',
  //   colorInDark: '#fff',
  // },
  {
    icon: 'mdi-google',
    color: '#db4437',
    colorInDark: '#db4437',
    fun:emit("loginWithFacebook")

  },
]
</script>

<template>
  <a href="http://127.0.0.1:8000/auth/google">
    <VBtn
    v-for="link in authProviders"
    :key="link.icon"
    :icon="link.icon"
    variant="text"
    :color="vuetifyTheme.global.name.value === 'dark' ? link.colorInDark : link.color"
  />
  </a>
</template>
