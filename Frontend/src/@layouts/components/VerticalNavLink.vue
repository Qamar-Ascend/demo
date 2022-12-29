<script lang="ts" setup>
import type { NavLink } from '@layouts/types';

const props = defineProps<{ item: NavLink}>()
</script>

<template>
  <li
    class="nav-link"
    :class="{ disabled: item.disable }"
  >
    <RouterLink
     :to="item.to"
    >
      <VIcon
        v-bind="item.icon"
        class="nav-item-icon"
      />
      <TransitionGroup name="transition-slide-x">
        <!-- 👉 Title -->
        <span
          key="title"
          class="nav-item-title"
        >
          {{ item.title }}
        </span>

        <!-- 👉 Badge -->
        <span
          v-if="item.badgeContent"
          key="badge"
          class="nav-item-badge"
          :class="item.badgeClass"
        >
          {{ item.badgeContent }}
        </span>
      </TransitionGroup>
    </RouterLink>
  </li>
</template>

<style lang="scss">
.layout-vertical-nav {
  .nav-link a {
    display: flex;
    align-items: center;
  }
}
</style>
