<template>

    <tr>
        <td>
            {{ attendance.student }}
        </td>
                                
        <td>
                       
        <div class="btn-group " role="group" aria-label="">

        <div class="btn-group" role="group">
            <button
                id=""
                @click="saveAttendance(1)"
                class="btn btn-secondary" 
                v-bind:class="{ 'btn-success': studentAttendance == 1 }">
                P <i class="fa fa-user"></i>
            </button>
        </div>
        
        <div class="btn-group" role="group">
            <button
                id=""
                @click="saveAttendance(2)"
                class="btn btn-secondary"
                v-bind:class="{ 'btn-warning': studentAttendance == 2 }">
                PP <i class="fa fa-clock-o"></i>
            </button>
        </div>
        
        <div class="btn-group" role="group">
            <button
                id=""
                @click="saveAttendance(3)"
                class="btn btn-secondary"
                v-bind:class="{ 'btn-info': studentAttendance == 3 }">
                AJ <i class="fa fa-exclamation"></i>
            </button>
        </div>
        
        <div class="btn-group" role="group">
            <button
                id=""
                @click="saveAttendance(4)"
                class="btn btn-secondary"
                v-bind:class="{ 'btn-danger': studentAttendance == 4 }">
                A <i class="fa fa-user-times"></i>
            </button>
        </div>
        
        </div>

        </td>

        </tr>

</template>



<script>

    export default {

        props: ['attendance', 'event', 'route'],
        
        data () {
            return {
                studentAttendance: this.attendance.attendance.attendance_type_id
            }
        },

        mounted() {

        },

        methods: {
            saveAttendance(attendance) {
                axios
                    .post(this.route, {
                        event_id: this.event.id,
                        student_id: this.attendance.student_id,
                        attendance_type_id: attendance
                    })
                    .then(response => {
                        this.studentAttendance = attendance
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
        }
    }
    
</script>
