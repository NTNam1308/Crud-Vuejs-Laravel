<template>
  <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">
      <CCard>
        <CCardBody>
            <h4>Crud Templates</h4>
            <CButton class="m-3" color="primary" @click="createTemplate()">Create Template</CButton>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CDataTable
              hover
              :items="items"
              :fields="fields"
              :items-per-page="10"
              pagination
            >
              <template #email="{item}">
                <td>
                  <strong>{{item.email}}</strong>
                </td>
              </template>
              <template #address="{item}">
                <td>
                  <strong>{{item.address}}</strong>
                </td>
              </template>
              <template #show="{item}">
                <td>
                  <CButton color="primary" @click="showCrud( item.id )">Show</CButton>
                </td>
              </template>
              <template #edit="{item}">
                <td>
                  <CButton color="primary" @click="editCrud( item.id )">Edit</CButton>
                </td>
              </template>
              <template #delete="{item}">
                <td>
                  <CButton color="danger" @click="deleteCrud( item.id )">Delete</CButton>
                </td>
              </template>
            </CDataTable>
        </CCardBody>  
      </CCard>
      </transition>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Cruds',
  data: () => {
    return {
      items: [],
      fields: ['email', 'address', 'show', 'edit', 'delete'],
      currentPage: 1,
      perPage: 5,
      totalRows: 0,
      message: '',
      showMessage: false,
      dismissSecs: 7,
      dismissCountDown: 0,
      showDismissibleAlert: false
    }
  },
  computed: {
  },
  methods: {
    getRowCount (items) {
      return items.length
    },
    noteLink (id) {
      return `crud/${id.toString()}`
    },
    editLink (id) {
      return `crud/${id.toString()}/edit`
    },
    showCrud ( id ) {
      const noteLink = this.noteLink( id );
      this.$router.push({path: noteLink});
    },
    editCrud ( id ) {
      const editLink = this.editLink( id );
      this.$router.push({path: editLink});
    },
    deleteCrud ( id ) {
      console.log('console  test');
      let self = this;
      axios.delete( this.$apiAdress + '/api/crud/destroy?id=' + id + '?token=' + localStorage.getItem("api_token"))
      .then(function (response) {
          self.items.forEach((item, i) => { 
            if (item.id == id) { 
              self.items.splice(i, 1); 
            } 
          });
      }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
      });
    },
    createTemplate () {
      this.$router.push({path: 'crud/create'});
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    getTemplates (){
      let self = this;
      axios.get(  this.$apiAdress + '/api/crud?token=' + localStorage.getItem("api_token") )
      .then(function (response) {
        self.items = response.data;
      }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
      });
    }
  },
  mounted: function(){
    this.getTemplates();
  }
}
</script>

<style scoped>
.card-body >>> table > tbody > tr > td {
  cursor: pointer;
}
</style>