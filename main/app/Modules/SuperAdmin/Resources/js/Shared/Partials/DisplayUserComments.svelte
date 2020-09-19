 <script>
   export let comments = [];
 </script>

 <div>
        <ul class="list-group list-group-flush rui-profile-activity-list">
          {#each comments as comment}
            <li class="list-group-item">
              <div class="media media-success media-retiring">
                <p class="media-link">
                  <span class="media-body">
                    <span class="media-title">
                      {comment.comment}
                    </span>
                    <small class="media-subtitle">{comment.user}</small>
                      <span class="media-time">{comment.date}</span>
                  </span>
                </p>
              </div>
            </li>
          {:else}
            <li class="list-group-item">
              <div class="media media-success media-retiring">
                <p class="media-link">
                  <span class="media-body">
                    <span class="media-title">NO COMMENTS</span>
                  </span>
                </p>
              </div>
            </li>
          {/each}

        </ul>
      </div>
