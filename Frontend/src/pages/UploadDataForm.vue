<script setup lang="ts">
const state = reactive({
  "name": undefined
})
</script>

<template>
  <div>
    <VRow>
      <VCol
      cols="12"
      md="12"
    >
      <!-- 👉 Horizontal Form -->
      <VCard title="Data Source - Create ">
        <VCardText>
          <VForm @submit.prevent="() => {}">
            <VRow>
              <VCol cols="12">
                <VRow no-gutters>
                  <!-- 👉 First Name -->
                  <VCol
                    cols="12"
                    md="3"
                  >
                    <label for="Name">Name</label>
                  </VCol>
        
                  <VCol
                    cols="12"
                    md="9"
                  >
                    <VTextField
                      id="firstName"
                      v-model="state.name"
                      placeholder="Enter Data Source Name"
                      persistent-placeholder
                    />
                  </VCol>
                </VRow>
              </VCol>
        
        
              <!-- 👉 submit and reset button -->
              <VCol
                offset-md="3"
                cols="12"
                md="9"
                class="d-flex gap-4"
              >
                <VBtn type="submit">
                  Submit
                </VBtn>
                <VBtn
                  color="secondary"
                  variant="tonal"
                  type="reset"
                >
                  Reset
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
    </VRow>
  </div>
</template>
