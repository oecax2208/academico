<template>

  <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title">
                    État client<!-- todo translate -->
                </div>

                <div class="box-tools pull-right">
                </div>  
            </div>
            
            <div class="box-body">

                <div class="btn-group" role="group"
                v-for="leadtype in leadtypes" v-bind:key="leadtype.id">
                    <button
                    class="btn btn-secondary"
                    v-bind:class="{ 'btn-info': status && status == leadtype.id }"
                    @click="saveStatus(leadtype.id)"
                    >
                        {{ leadtype.name }}
                    </button>
            </div>
        </div>
    </div>
  </div>
</template>



<script>

    export default {

        props: ['student', 'route', 'leadtypes'],
        
        data () {
            return {
                status: this.student.lead_type_id
            }
        },

        mounted() {

        },

        methods: {

            saveStatus(status)
            {
                console.log('click');
                axios
                    .post(this.route, {
                        student: this.student.id,
                        status: status
                    })
                    .then(response => {
                        this.status = response.data;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
                
            },

        }
    }
    
</script>
