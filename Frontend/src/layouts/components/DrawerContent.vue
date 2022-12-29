<script setup lang="ts">
import upgradeBannerDark from '@/assets/images/pro/upgrade-banner-dark.png'
import upgradeBannerLight from '@/assets/images/pro/upgrade-banner-light.png'
import logo from '@/assets/logo.svg?raw'
import { VerticalNavLink, VerticalNavSectionTitle } from '@layouts'
import { useTheme } from 'vuetify'

const vuetifyTheme = useTheme()
const upgradeBanner = computed(() => {
  return vuetifyTheme.global.name.value === 'dark' ? upgradeBannerLight : upgradeBannerDark
})
</script>

<template>
  <!-- 👉 Nav header -->
  <div class="nav-header">
    <RouterLink
      to="/"
      class="app-logo d-flex align-center gap-x-3 app-title-wrapper"
    >
      <!-- ℹ️ You can also use img tag or VImg here -->
      <div v-html="logo" />

      <Transition name="vertical-nav-app-title">
        <h1 class="font-weight-semibold leading-normal text-xl">Demo</h1>
      </Transition>
    </RouterLink>
  </div>

  <!-- 👉 Nav items -->
  <ul>
    <VerticalNavLink
      :item="{
        title: 'Dashboard',
        to: '/',
        icon: { icon: 'mdi-home-outline' },
      }"
    />

    <!-- 👉 DataSources -->
    <VerticalNavSectionTitle :item="{ heading: 'User' }" />
    <VerticalNavLink
      :item="{
        title: 'New',
        to: '/user/form',
        icon: { icon: 'mdi-account-plus-outline' },
      }"
    />

    <VerticalNavLink
      :item="{
        title: 'List',
        to: '/user',
        icon: { icon: 'mdi-login' },
      }"
    />

    <!-- 👉 Upload Data -->
    <VerticalNavSectionTitle :item="{ heading: 'Survey' }" />
    <VerticalNavLink
      :item="{
        title: 'New',
        to: '/Survey/form',
        icon: { icon: 'mdi-account-plus-outline' },
      }"
    />

    <VerticalNavLink
      :item="{
        title: 'List',
        to: '/survey',
        icon: { icon: 'mdi-login' },
      }"
    />
  </ul>
</template>

<style lang="scss">
// .v-navigation-drawer {
//   height: 100%;

//   .v-navigation-drawer__content {
//     display: flex;
//     flex-direction: column;

//     > ul {
//       flex-grow: 1;
//     }
//   }
// }

.upgrade-banner {
  margin-top: auto;
  // position: absolute;
  // bottom: 13px;
  // left: 50%;
  // transform: translateX(-50%);
}
</style>
