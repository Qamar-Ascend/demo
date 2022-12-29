<script setup lang="ts">
import avatar1 from '@/assets/images/avatars/avatar-1.png';
import type { Anchor } from 'vuetify/lib/components';

const avatarBadgeProps = {
  dot: true,
  location: 'bottom right' as Anchor,
  offsetX: 3,
  offsetY: 3,
  color: 'success',
  bordered: true,
}
const router=useRouter()

//HANDLE LOGOUT CALL
const logOut=()=>{
 localStorage.clear()
 router.push("/login")
}
</script>

<template>
  <VBadge v-bind="avatarBadgeProps">
    <VAvatar
      style="cursor: pointer;"
      color="primary"
      variant="tonal"
    >
      <VImg :src="avatar1" />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="230"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge v-bind="avatarBadgeProps">
                  <VAvatar
                    color="primary"
                    size="40"
                    variant="tonal"
                  >
                    <VImg :src="avatar1" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold">
              John Doe
            </VListItemTitle>
            <VListItemSubtitle class="text-disabled">
              Admin
            </VListItemSubtitle>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <VListItem @click="logOut">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="mdi-logout-variant"
                size="22"
              />
            </template>

            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
</template>
