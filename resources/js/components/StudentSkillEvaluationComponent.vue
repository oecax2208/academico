<template>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title">
                    Compétences <!-- todo TRANSLATE -->
                </div>

                <div class="box-tools pull-right">
                </div>  
            </div>
            
            <div class="box-body">

            <table class="table table-striped" id="skillsTable">
                <thead>
                    <th>Skill</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <tr v-for="skill in skills" v-bind:key="skill.id">
                        <td style="width: 50%">{{ skill.name }}</td>
                        
                        <td>
                        <div class="btn-group btn-group-justified" role="group" aria-label="">

                            <!-- todo get styling from the model -->
                            <div class="btn-group" role="group"
                            v-for="(skillScale) in skillScales" v-bind:key="skillScale.id">
                                <button
                                class="btn btn-secondary"
                                v-bind:class="{
                                    'btn-success': skillScale.value > 0.75 && skill.status == skillScale.id,
                                    'btn-warning': 0.4 <= skillScale.value && 0.75 >= skillScale.value && skill.status == skillScale.id,
                                    'btn-danger': skillScale.value < 0.5 && skill.status == skillScale.id
                                }"
                                v-on:click="saveSkillStatus(skill, skillScale.id)"
                                >
                                    {{ skillScale.name.fr }}
                                </button>
                            </div>

                        </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            </div>
        </div>
    </div>
</template>



<script>

    export default {

        props: ['saved_skills', 'student', 'course', 'skill_scales', 'route'],
        
        data () {
            return {
                skills: this.saved_skills,
                skillScales: this.skill_scales
            }
        },

        mounted() {

        },

        methods: {
            saveSkillStatus(skill, status)
            {
                axios
                    .post(this.route, {
                        skill: skill.id,
                        status,
                        student: this.student.id,
                        course: this.course.id,
                    })
                    .then(response => {
                        skill.status = response.data
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            }
        }
    }
    
</script>
