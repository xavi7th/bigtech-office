<script>
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import FlashMessage from "@usershared/FlashMessage";
    import { onMount } from "svelte";
    import route from "ziggy";

    $: ({ errors, auth } = $page);
    let activeComments = {},
        activeUserName = null;

    let setActiveComments = obj => {
        activeUserName = obj.meta.full_name;
        activeComments = _.omit(obj, "meta");
    };

    export let userComments = {};

    onMount(() => {
        let sampleUserComment = Object.entries(userComments);
        let sampleComment = _.takeRight(sampleUserComment[0], 1)[0];
        setActiveComments(sampleComment);
    });
</script>

<Layout title="View Users Comments">
    <div class="container-fluid">
        <form class="rui-messenger rui-messenger-full no-emoji">
            <div class="rui-messenger-head">
                <div class="rui-messenger-head-search">
                    <div class="input-group rui-messenger-search">
                        <button
                            type="button"
                            class="btn btn-clean btn-uniform btn-grey-5"
                            data-toggle="button"
                            aria-pressed="false">
                            <span
                                data-feather="search"
                                class="rui-icon rui-icon-stroke-1_5" />
                        </button>
                        <input
                            type="search"
                            class="form-control form-control-clean"
                            placeholder="Type to filter users..."
                            data-toggle="input"
                            autocomplete="off" />
                    </div>
                </div>
                <div class="rui-messenger-head-buttons d-none d-lg-block">
                    <ul>
                        <!-- <li class="mr-auto">
              <button type="button" class="btn btn-custom-round">
                <span
                  data-feather="folder"
                  class="rui-icon rui-icon-stroke-1_5" />
              </button>
            </li>
            <li>
              <button type="button" class="btn btn-custom-round">
                <span
                  data-feather="more-vertical"
                  class="rui-icon rui-icon-stroke-1_5" />
              </button>
            </li>
            <li>
              <button
                type="button"
                class="btn btn-brand btn-uniform btn-round btn-sm">
                <span
                  data-feather="plus"
                  class="rui-icon rui-icon-stroke-1_5" />
              </button>
            </li> -->
                    </ul>
                </div>
                <button
                    class="btn btn-custom-round mr-25 d-flex d-lg-none"
                    type="button">
                    <span
                        data-feather="more-vertical"
                        class="rui-icon rui-icon-stroke-1_5" />
                </button>
            </div>
            <div class="rui-messenger-list rui-scrollbar">
                <a
                    class="btn rui-messenger-collapse-btn"
                    data-toggle="collapse"
                    href="#collapseFullOnline"
                    role="button"
                    aria-expanded="false"
                    aria-controls="collapseFullOnline">
                    Users
                    <span
                        data-feather="chevron-right"
                        class="rui-icon rui-icon-stroke-1_5" />
                </a>
                <div class="collapse show" id="collapseFullOnline">
                    <div class="rui-messenger-collapse">

                        {#each Object.entries(userComments) as [user, details], idx (idx)}
                            <div
                                class="media media-success media-filled"
                                class:active={activeUserName === details.meta.full_name}
                                on:click={() => {
                                    setActiveComments(details);
                                }}>
                                <a
                                    href="#home"
                                    class="media-link rui-messenger-item">
                                    <span class="media-img">
                                        <img
                                            src={details.meta.avatar || `/img/avatar-${idx + 1}.png`}
                                            alt="" />
                                    </span>
                                    <span class="media-body">
                                        <span class="media-title">
                                            {details.meta.full_name}
                                        </span>
                                        <small class="media-subtitle">
                                            {user}
                                        </small>
                                        <small class="media-subtitle">
                                            {details.meta.department}
                                        </small>
                                    </span>
                                </a>
                                <a href="#home" class="media-icon">
                                    <span
                                        data-feather="x"
                                        class="rui-icon rui-icon-stroke-1_5" />
                                </a>
                            </div>
                        {:else}
                            <div class="media media-success media-filled">
                                <a
                                    href="#home"
                                    class="media-link rui-messenger-item">
                                    <span class="media-img">N/A</span>
                                    <span class="media-body">
                                        <span class="media-title">
                                            NO USER COMMENTS
                                        </span>
                                    </span>
                                </a>
                            </div>
                        {/each}
                    </div>
                </div>
            </div>
            <div class="rui-messenger-footer">
                <button type="button" class="btn btn-custom-round">
                    <span
                        data-feather="more-vertical"
                        class="rui-icon rui-icon-stroke-1_5" />
                </button>
                <button
                    type="button"
                    class="btn btn-brand btn-uniform btn-round btn-sm">
                    <span
                        data-feather="plus"
                        class="rui-icon rui-icon-stroke-1_5" />
                </button>
            </div>
            <div class="rui-messenger-chat">

                <div class="rui-messenger-head">
                    <a
                        href="#"
                        class="btn btn-clean btn-uniform btn-grey-4
                        rui-messenger-back d-flex d-lg-none">
                        <span
                            data-feather="chevron-left"
                            class="rui-icon rui-icon-stroke-1_5" />
                    </a>
                    <h4 class="mnb-4">{activeUserName}</h4>
                    <button
                        type="button"
                        class="btn btn-custom-round d-flex d-lg-none">
                        <span
                            data-feather="more-vertical"
                            class="rui-icon rui-icon-stroke-1_5" />
                    </button>
                </div>

                <div class="rui-messenger-body rui-scrollbar">
                    <div>

                        <div
                            class="rui-messenger-message
                            rui-messenger-message-structure">
                            <ul>
                                <li />
                            </ul>
                            <div class="rui-messenger-message-edit">
                                <a href="#" class="btn">
                                    <span
                                        data-feather="edit-2"
                                        class="rui-icon rui-icon-stroke-1_5" />
                                </a>
                                <a href="#" class="btn">
                                    <span
                                        data-feather="trash"
                                        class="rui-icon rui-icon-stroke-1_5" />
                                </a>
                            </div>
                            <small class="rui-messenger-message-time" />
                        </div>

                        {#each Object.entries(activeComments) as [humanTime, comments]}
                            <small class="rui-messenger-message-datetime">
                                {humanTime}
                            </small>
                            {#each comments as comment}
                                <div
                                    class="rui-messenger-message
                                    rui-messenger-message-incoming">
                                    <ul>
                                        <li>
                                            <blockquote
                                                class="blockquote
                                                blockquote-style-2">
                                                <strong>
                                                    Subject: {comment.subject}
                                                </strong>
                                            </blockquote>
                                        </li>
                                        <li>{comment.comment}</li>
                                    </ul>
                                    <small class="rui-messenger-message-time">
                                        {comment.time}
                                    </small>
                                </div>
                            {/each}
                        {/each}

                    </div>
                </div>
            </div>
        </form>
    </div>
</Layout>
