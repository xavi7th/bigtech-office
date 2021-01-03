<script>
  import Layout from "@usershared/UserLayout.svelte";
  import FlashMessage from "@usershared/FlashMessage.svelte";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";

  import axios from "axios";
  import { getErrorString } from "@public-assets/js/bootstrap";
  $: ({ errors, flash } = $page);

  let details = {
      remember: true
    },
    formSubmitted = false;

  let handleLogin = e => {
    if (e.target.checkValidity() === false) {
      e.stopPropagation();
      e.target.classList.add("was-validated");
      return;
    } else {
      formSubmitted = true;
      BlockToast.fire({ text: "Accessing your dashboard..." });

      e.target.classList.remove("was-validated");

      Inertia.post(route("app.login"), details).then(() => {
        swal.close();
        if (_.size(errors) !== 0) {
          e.target.classList.remove("was-validated");
          // emailField.setCustomValidity("There are errors on your form");
        } else if (flash.error == 401) {
          swal
            .fire({
              title: "One more thing!",
              text: `This seems to be your first login. You need to supply a password`,
              icon: "info"
            })
            .then(() => {
              swal
                .fire({
                  title: "Enter a password",
                  input: "text",
                  inputAttributes: {
                    autocapitalize: "off",
                    autocomplete: false,
                    placeholder: "New password"
                  },
                  showCancelButton: true,
                  confirmButtonText: "Set Password",
                  showLoaderOnConfirm: true,
                  preConfirm: pw => {
                    if (!pw) {
                      swal.showValidationMessage(
                        `You must provide a password for your account`
                      );
                      return false;
                    }
                    return Inertia.post(route("app.password.new"), {
                      pw,
                      email: details.email
                    })
                      .then(() => {
                        if (flash.error || _.size(errors) > 0) {
                          throw new Error(
                            flash.error || getErrorString(errors)
                          );
                        } else {
                          swal.close();
                          return { rsp: true };
                        }
                      })
                      .catch(error => {
                        swal.showValidationMessage(`Request failed: ${error}`);
                      });
                  },
                  allowOutsideClick: () => !swal.isLoading()
                })
                .then(result => {
                  if (flash.success == 204) {
                    swal.fire({
                      title: `Success`,
                      text:
                        "Password set successfully! Login using your new credentials",
                      icon: "success"
                    });
                  } else if (result.dismiss) {
                    swal.fire({
                      title: "Cancelled",
                      text: "You can´t login without setting a password",
                      icon: "info"
                    });
                  }
                });
            });
        }
      });
    }
  };
</script>

<style lang="scss">
  .rui-sign-form-cloud {
    max-width: 410px;
  }

  .rui-social-links {
    display: flex;
    justify-content: space-evenly;

    li {
      padding: 0;
    }
    &:after {
      content: none;
    }
  }
</style>

<Layout title="Login">
  <form
    class="form rui-sign-form rui-sign-form-cloud"
    on:submit|preventDefault={handleLogin}
    novalidate>
    <div class="row vertical-gap sm-gap justify-content-center">
      <div class="col-12">
        <h1 class="display-4 mb-10 text-center">Sign In</h1>
      </div>

      <div class="col-12">
        <input
          type="email"
          required
          class="form-control"
          class:is-invalid={errors.email}
          class:is-valid={formSubmitted && !errors.email}
          id="email"
          bind:value={details.email}
          placeholder="Email" />
        {#if errors.email}
          <FlashMessage formError={errors.email[0]} />
        {/if}
      </div>
      <div class="col-12">
        <input
          type="password"
          required
          class="form-control"
          class:is-invalid={errors.password}
          id="password"
          bind:value={details.password}
          placeholder="Password" />
        {#if errors.password}
          <FlashMessage formError={errors.password[0]} />
        {/if}
      </div>
      <div class="col-sm-6">
        <div
          class="custom-control custom-checkbox d-flex justify-content-start">
          <input
            type="checkbox"
            class="custom-control-input"
            id="rememberMe"
            bind:value={details.remember} />
          <label class="custom-control-label fs-13" for="rememberMe">
            Remember me
          </label>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="d-flex justify-content-end">
          <a href class="fs-13">Forgot password?</a>
        </div>
      </div>
      <div class="col-12">
        <button class="btn btn-brand btn-block text-center">Sign in</button>
      </div>
      <div class="col-12">
        <div class="rui-sign-or mt-2 mb-5">or</div>
      </div>
      <div class="col-12">
        <ul class="rui-social-links">
          <li>
            <a href class="rui-social-github">
              <span class="fab fa-github" />
              Github
            </a>
          </li>
          <li>
            <a href class="rui-social-facebook">
              <span class="fab fa-facebook-f" />
              Facebook
            </a>
          </li>
          <li>
            <a href class="rui-social-google">
              <span class="fab fa-google" />
              Google
            </a>
          </li>
        </ul>
      </div>
    </div>
  </form>
  <div class="mt-20 text-grey-6">
    Don't you have an account?
    <InertiaLink href={route('app.register.show')} class="text-1">
      Sign Up
    </InertiaLink>
  </div>
</Layout>
