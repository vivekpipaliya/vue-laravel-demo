<template>
  <div id="app">
    <b-col md="6" offset-md="3" class="text-left">
      <b-alert
        :show="dismissCountDown"
        dismissible
        :variant="variant"
      >
        {{msg}}
      </b-alert>
      <b-form @submit="onSubmit" @reset="onReset">

        <b-form-group label="Your Name:" label-for="name">
          <b-form-input
            id="name"
            v-model="form.name"
            placeholder="Enter name"
            autofocus
            :class="{ 'is-invalid': !submitted && $v.form.name.$error }"
          ></b-form-input>
          <div v-if="!submitted && $v.form.name.$error" class="invalid-feedback">
              <span v-if="!$v.form.name.required">Name is required</span>
          </div>
        </b-form-group>

        <b-form-group
          id="input-group-1"
          label="Email address:"
          label-for="email"
        >
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            placeholder="Enter email"
            :class="{ 'is-invalid': !submitted && $v.form.email.$error }"
          ></b-form-input>
          <div v-if="!submitted && $v.form.email.$error" class="invalid-feedback">
              <span v-if="!$v.form.email.required">Email is required</span>
              <span v-if="!$v.form.email.email">Email is invalid</span>
          </div>
        </b-form-group>

        <b-form-group label="Your Phone:" label-for="phone_number">
          <b-form-input
            id="phone_number"
            v-model="form.phone_number"
            placeholder="Enter Phone Number"
            :class="{ 'is-invalid': !submitted && $v.form.phone_number.$error }"
            v-on:input="numberFormat"
          ></b-form-input>
          <div v-if="!submitted && $v.form.phone_number.$error" class="invalid-feedback">
              <span v-if="!$v.form.phone_number.required">Phone number is required</span>
              <span v-if="!$v.form.phone_number.phone">Phone number is invalid</span>
          </div>
        </b-form-group>

        <b-form-group label="Address:">
          <b-form-textarea
            id="textarea"
            v-model="form.address"
            placeholder="Enter address"
            rows="2"
            max-rows="6"
          ></b-form-textarea>
        </b-form-group>

        <b-form-group label="Zip code:" label-for="zipcode">
          <b-form-input
            id="zipcode"
            v-model="form.zipcode"
            placeholder="Enter zip code"
            :class="{ 'is-invalid': !submitted && $v.form.zipcode.$error }"
          ></b-form-input>
          <div v-if="!submitted && $v.form.zipcode.$error" class="invalid-feedback">
              <span v-if="!$v.form.zipcode.required">Zipcode is required</span>
          </div>
        </b-form-group>

        <b-form-group label="Document:">
          <b-form-file
            v-model="form.document"
            placeholder="Choose a file or drop it here..."
            drop-placeholder="Drop file here..."
            type="file"
            id="profile-image"
            @input="previewImage"
          ></b-form-file>
        </b-form-group>
        

        <b-button type="submit" variant="primary">Submit</b-button> &nbsp;
        <b-button type="reset" variant="danger">Reset</b-button>
      </b-form>
    </b-col>
  </div>
</template>

<script>
import axios from "./config";
import { required, email, minLength, helpers } from "vuelidate/lib/validators"
const number = helpers.regex('number', /^[0-9]+$/)
const phone = helpers.regex('phone', /^[(]?\d{3}[)]?[(\s)?.-]\d{3}[\s.-]\d{4}$/)

export default {
  name: 'App',
  data() {
      return {
        form: {
          email: '',
          name: '',
          phone_number: '',
          address: '',
          zipcode: '',
          document: null,
        },
        submitted: false,
        documentData: null,
        message: true,
        msg: '',
        dismissSecs: 3,
        dismissCountDown: 0,
        variant: ''
      }
    },
    validations: {
        form: {
            name: { required },
            email: { required, email },
            phone_number: { required, phone },
            zipcode: {required, minLength: minLength(5), number}
        }
    },
    methods: {
      onSubmit(evt) {
        var that = this;
        evt.preventDefault()
        this.$v.$touch();
        if (this.$v.$invalid) {
          return
        }
        const formData = new FormData();
        formData.append('document', this.form.document);
        formData.append('email', this.form.email);
        formData.append('name', this.form.name);
        formData.append('phone_number', this.form.phone_number);
        formData.append('address', this.form.address);
        formData.append('zipcode', this.form.zipcode);

        axios.post('/submit', formData,{
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(function (response) {
          that.dismissCountDown = 0
          that.message = true
          that.msg = response.data
          that.dismissCountDown = that.dismissSecs
          that.variant = 'danger';

          if (response.data == 'Form submitted!') {
            that.variant = 'success';
            evt.target.reset();
          }
          setTimeout(() => {
            that.dismissCountDown = 0
          }, 1000);
            
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(function () {
          // always executed
        }); 
      },
      onReset(evt) {
        evt.preventDefault()
        this.form.email = '';
        this.form.name = '';
        this.form.phone_number = '';
        this.form.address = '';
        this.form.zipcode = '';
        this.form.document = null;
        this.$v.$reset();
      },
      previewImage: function(event) {
        // var input = event.target;
        this.form.document = event;
        // console.log(event)
        // if (input.files && input.files[0]) {
        //   this.form.document = input.files[0];
        //   var reader = new FileReader();
        //   reader.onload = (e) => {
        //     this.documentData = e.target.result;
        //   }
        //   reader.readAsDataURL(input.files[0]);
        // }
      },
      numberFormat(event) {
        var r = /(\D+)/g,
        npa = '',
        nxx = '',
        last4 = '';
        event = event.replace(r, '');
        npa = event.substr(0, 3);
        nxx = event.substr(3, 3);
        last4 = event.substr(6, 4);
        event = '(' + npa + ')' + ' ' + nxx + '-' + last4;
        this.form.phone_number = event;
      }
    }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
