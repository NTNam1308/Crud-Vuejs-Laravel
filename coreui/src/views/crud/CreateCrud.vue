<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h4>
            Create Crud Template
          </h4>
          <CAlert
            :show.sync="dismissCountDown"
            color="primary"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>

            <CInput label="Email" type="text" placeholder="Name" v-model="template.email"></CInput>

            <CInput label="Address" type="text" placeholder="Subject" v-model="template.address"></CInput>

          <CButton color="primary" @click="store()">Create</CButton>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'CreateEmailTemplate',
  data: () => {
    return {
        template: {
            email: '',
            address: '',
        },
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
        showDismissibleAlert: false
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    store() {
        let self = this;
        axios
        .post(this.$apiAdress + "/api/crud/store", { 
          token: localStorage.getItem("api_token"), 
          email: self.template.email, 
          address: self.template.address, 
        }) 
        .then(function (response) {
          console.log(response.data);
        }).catch(function (error) {
            
        });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
  },
  mounted: function(){

  }
}

</script>
