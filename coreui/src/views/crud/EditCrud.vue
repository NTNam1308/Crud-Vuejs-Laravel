<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard>
        <CCardBody>
          <h3>
            Edit Crud Template
          </h3>
          <CAlert
            :show.sync="dismissCountDown"
            color="primary"
            fade
          >
            ({{dismissCountDown}}) {{ message }}
          </CAlert>

            <CInput label="Email" type="text" placeholder="Email" v-model="template.email"></CInput>
            <CInput label="Address" type="text" placeholder="Address" v-model="template.address"></CInput>

          <CButton color="primary" @click="update()">Save</CButton>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'EditCrudTemplate',
  data: () => {
    return {
        template: {
            email: '',
            address: '',
        },
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    update() {
        let self = this;
      
      axios 
        .post( this.$apiAdress + '/api/crud/update', { 
          id: self.$route.params.id,
          email: self.template.email,
          address: self.template.address,
          token: localStorage.getItem("api_token"), 
        })
        //  axios.put(  this.$apiAdress + '/api/crud/update' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
        // {
        //     _method: 'PUT',
        //     email: self.template.email,
        //     address: self.template.address,
        // })
        .then(function (response) {
          console.log(response.data);
        }).catch(function (error) {
            
        });
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
  },
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/crud/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.template = response.data.template;
    }).catch(function (error) {
        console.log(error);
        self.$router.push({ path: '/login' });
    });
  }
}


</script>
