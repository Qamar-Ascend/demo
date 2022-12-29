<script setup lang="ts">
import useValidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { useRouter } from "vue-router";
import { ApiService } from "../../services/ApiService";

const router = useRouter();
const state = reactive({
  name:"",

})


//DEFINE VALIDATION RULES
const rules = {
  name: { required },
};

const v$ = useValidate(rules, state);

const  onSubmit =async()=>{
  
   const result = await v$.value.$validate().then();
  if (!result) {
    return;
  }
  
   ApiService.post("surveyCreate",state).then((response)=>{
    if(response.status===200 && response.data){
     router.push("/survey")   
    }
    
  },(error)=>{
    console.log("error",error);
    
  })
}



</script>

<template>
  <div>
    <VRow>
      <VCol
      cols="12"
      md="12"
    >
      <!-- 👉 Horizontal Form -->
      <VCard title="Survey - Create ">
        <VCardText>
          <VForm @submit.prevent="onSubmit">
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
                      id="name"
                      v-model="state.name"
                      placeholder="Enter  Name"
                      persistent-placeholder
                    />
                    <div class="text-error mt-1" v-if="v$.name.$error">
                    Name is required.
                  </div>
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
                  to="/survey"
                >
                  Cancel
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
