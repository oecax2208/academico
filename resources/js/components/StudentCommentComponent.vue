<template>

<div class="box">
    <div class="box-header with-border">
        <div class="box-title">
            Commentaires
        </div>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    
    <div class="box-body">
        <ul>
            <li v-for="comment in comments" v-bind:key="comment.id">
                {{ comment.body }} ({{comment.created_at | moment("D MMM YY") }})
                <button type="button" @click="deleteComment(comment.id)" class="btn btn-danger btn-xs">X</button>
            </li>
        </ul>
    </div>

    <!-- Modal / todo translate buttons -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nouveau commentaire</h4>
      </div>

      <div class="modal-body">
        <textarea name="comment" id="comment" style="width: 100%" rows="5" v-model="comment_body"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="button" @click="addComment()" class="btn btn-primary">Enregister</button>
      </div>
    </div>
  </div>
</div>

</div>
</template>

<script>
    
    export default {

        props: ['comments', 'student', 'route'],

        data () {
            return {
                comment_body: null,
                errors: [],
            }
        },

        mounted() {

        },

        methods: {
            addComment()
            {
                axios
                    .post(this.route, {
                        comment: this.comment_body,
                        student_id: this.student.id,
                    })
                    .then(response => {
                        document.location.reload(true); // TODO improve this: do not reload the whole page
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },

            deleteComment(comment)
            {
                axios
                    .delete('/comment/'+comment)
                    .then(response => {
                        document.location.reload(true); // TODO improve this: do not reload the whole page
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            }
        }
    }
</script>
