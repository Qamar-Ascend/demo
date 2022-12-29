<script setup lang="ts">
import authV1MaskDark from '@/assets/images/pages/auth-v1-mask-dark.png';
import authV1MaskLight from '@/assets/images/pages/auth-v1-mask-light.png';
import authV1Tree2 from '@/assets/images/pages/auth-v1-tree-2.png';
import authV1Tree from '@/assets/images/pages/auth-v1-tree.png';
import logo from '@/assets/logo.svg?raw';
import { ApiService } from '@/services/ApiService';
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue';
import useValidate from "@vuelidate/core";
import { email, required } from "@vuelidate/validators";
import { useTheme } from 'vuetify';

const form = ref({
  name: '',
  email: '',
  password: '',
})
const router = useRouter();
const vuetifyTheme = useTheme()
const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light'
    ? authV1MaskLight
    : authV1MaskDark
})
const isPasswordVisible = ref(false)

//DEFINE VALIDATION RULES
const rules = {
  name: { required },
  email: { required,email },
  password: { required },
};

const v$ = useValidate(rules, form);

//REGISTER USER CALL
const handleSubmit=async()=>{
 const result = await v$.value.$validate().then();
  if (!result) {
    return;
  }
   
  ApiService.post("register",form.value).then((response)=>{
    if(response.status===200 && response.data){
     router.push("/login")   
    }
    
  },(error)=>{
    console.log("error",error);
    
  })
}
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard
      class="auth-card pa-4 pt-7"
      max-width="448"
    >
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <div v-html="logo"></div>
          </div>
        </template>

        <VCardTitle class="font-weight-semibold text-2xl text-uppercase">
          Demo
        </VCardTitle>
      </VCardItem>

      <!-- <VCardText class="pt-2">
        <h5 class="text-h5 font-weight-semibold mb-1">
          Adventure starts here 🚀
        </h5>
        <p class="mb-0">
          Make your app management easy and fun!
        </p>
      </VCardText> -->

      <VCardText>
        <VForm @submit.prevent="handleSubmit">
          <VRow>
            <!-- Username -->
            <VCol cols="12">
              <VTextField
                v-model="form.name"
                label="Username"

              />
              <div class="text-error mt-1" v-if="v$.name.$error">
                  Name is required.
              </div>
            </VCol>
            <!-- email -->
            <VCol cols="12">
              <VTextField
                v-model="form.email"
                label="Email"
                type="email"
              />
              <div class="text-error mt-1" v-if="v$.email.$error">
                  Email is required.
              </div>
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField
                v-model="form.password"
                label="Password"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />
              <div class="text-error mt-1" v-if="v$.password.$error">
                  Password is required.
                </div>

              <VBtn
                block
                class="mt-5"
                type="submit"
              >
                Sign up
              </VBtn>
            </VCol>

            <!-- login instead -->
            <VCol
              cols="12"
              class="text-center text-base"
            >
              <span>Already have an account?</span>
              <RouterLink
                class="text-primary ms-2"
                to="login"
              >
                Sign in instead
              </RouterLink>
            </VCol>

            <VCol
              cols="12"
              class="d-flex align-center"
            >
              <VDivider />
              <span class="mx-4">or</span>
              <VDivider />
            </VCol>

            <!-- auth providers -->
            <VCol
              cols="12"
              class="text-center"
            >
              <AuthProvider />
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>

    <VImg
      class="auth-footer-start-tree d-none d-md-block"
      :src="authV1Tree"
      :width="250"
    />

    <VImg
      :src="authV1Tree2"
      class="auth-footer-end-tree d-none d-md-block"
      :width="350"
    />

    <!-- bg img -->
    <VImg
      class="auth-footer-mask d-none d-md-block"
      :src="authThemeMask"
    />
  </div>
</template>

<style lang="scss">
@use "@core/scss/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
  layout: blank
</route>
