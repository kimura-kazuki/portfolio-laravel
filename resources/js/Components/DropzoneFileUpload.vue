<template>
  <div class="mb-3 dropzone dz-clickable"
       :class="[multiple ? 'dropzone-multiple': 'dropzone-single']">
    <div class="fallback">
      <div class="custom-file">
        <input type="file"
               class="custom-file-input"
               id="projectCoverUploads"
               :multiple="multiple">
        <label class="custom-file-label" for="projectCoverUploads">ファイルを選択してください</label>
      </div>
    </div>
    <div v-if="!multiple"
         class="dz-preview dz-preview-single"
         :class="previewClasses"
         ref="previewSingle">
      <div class="dz-preview-cover">
        <img class="dz-preview-img" data-dz-thumbnail>
      </div>
    </div>
    <ul v-else
        flush=""
        class="mb-3 dz-preview dz-preview-multiple list-group list-group-lg list-group-flush"
        :class="previewClasses"
        ref="previewMultiple">
      <li class="px-0 list-group-item dz-processing dz-image-preview">
        <div class="row">
          <div class="col-auto">
            <div class="thumbnail">
              <img rounded class="thumbnail-img" data-dz-thumbnail />
            </div>
          </div>
          <div class="col ml--3">
            <h4 class="mb-1 bold" data-dz-name>...</h4>
            <!-- <p class="mb-0 text-xs text-muted" data-dz-size>...</p> -->
          </div>
          <div class="col-auto">
            <button data-dz-remove="true" class="button btn-danger btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"> <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> </svg>
            </button>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
import axios from 'axios';
import Dropzone from 'dropzone';
import { notify } from "notiwind";

  export default {
    name: 'DropzoneFileUpload',
    props: {
      options: {
        type: Object,
        default: () => ({})
      },
      value: [String, Object, Array],
      url: {
        required: true,
        type: String,
        // default: 'http://'
      },
      deleteUrl: {
        required: true,
        type: String,
        default: 'http://'
      },
      multiple: Boolean,
      previewClasses: [String, Object, Array],
    //   productId: Number,
      defaultImages: Object,
    },
    model: {
      prop: 'value',
      event: 'change'
    },
    data() {
      return {
        currentFile: null,
        files: [],
        showList: false,
      }
    },
    methods: {
      initDropzone() {
        // let Dropzone = await import('dropzone');
        // Dropzone = Dropzone.default || Dropzone;
        Dropzone.autoDiscover = false;

        let preview = this.multiple ? this.$refs.previewMultiple : this.$refs.previewSingle;

        let self = this;

        // csrfトークン（暗号化）をcookieから取得
        let csrfToken = document.cookie.split('; ').find(row => row.startsWith('XSRF-TOKEN=')).split('=')[1];
        let csrfTokenDecode = decodeURIComponent(csrfToken);

        this.dropzone = new Dropzone(this.$el, {
          ...this.options,
          headers: {
            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            'X-XSRF-TOKEN': csrfTokenDecode
          },
          url: this.url,
          dictDefaultMessage: 'ここにファイルをドラッグ＆ドロップ、または、クリックしてファイルを選択',
          thumbnailWidth: null,
          thumbnailHeight: null,
          previewsContainer: preview,
          previewTemplate: preview.innerHTML,
          maxFiles: (!this.multiple) ? 1 : null,
          acceptedFiles: (!this.multiple) ? 'image/*' : null,
          init: function () {
            this.on("addedfile", function (file) {
              if (!self.multiple && self.currentFile) {
                  // this.removeFile(this.currentFile);
              }
              self.currentFile = file;
            });

            this.on("error", function (file, message) {
                console.log('error');
                console.log(file);
                console.log(message);
                notify({
                    group: "error",
                    title: "Error",
                    // text: message.message ?? message,
                    text: "エラーが発生しました。",
                }, 5000);
            });

            // アップロード完了後処理
            this.on("complete", function (file) {
            //   console.log('complete');
            //   console.log(file);
              if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                if (typeof file.xhr !== "undefined") {
                    // console.log(file.xhr.response);
                    // console.log(file.xhr.responseText);
                //   let response = JSON.parse(file.xhr.response);
                //   console.log(response.product_image_id);
                }
              }
            });
          },
          removedfile: file => {
            // console.log('removedfile');
            // console.log(file);

            // 画像ID取得
            // アップロード直後と既存の画像で取得方法が異なる
            let imageId = 0;
            if (typeof file.xhr !== "undefined") {
              let response = JSON.parse(file.xhr.response);
              imageId = response.image_id;
            } else {
              imageId = file.imageId;
            }

            this.$swal({
                icon: 'info',
                text: '画像を削除しますか？',
                showCancelButton: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    console.log(imageId);
                    axios.delete(
                        this.deleteUrl,
                    ).then(res => {
                        // 表示されている画像を消去
                        var previewElement;
                        return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
            })
          }
        });

        preview.innerHTML = ''

        let evtList = ['drop', 'dragstart', 'dragend', 'dragenter', 'dragover', 'addedfile', 'removedfile', 'thumbnail', 'error', 'processing', 'uploadprogress', 'sending', 'success', 'complete', 'canceled', 'maxfilesreached', 'maxfilesexceeded', 'processingmultiple', 'sendingmultiple', 'successmultiple', 'completemultiple', 'canceledmultiple', 'totaluploadprogress', 'reset', 'queuecomplete']

        evtList.forEach(evt => {
          this.dropzone.on(evt, (data, xhr, formData) => {
            // this.$emit(evt, data);

            if (evt === 'addedfile' && data.status === 'added') {
            //   console.log('addedfile');
            //   console.log(data);
            //   console.log(formData);
            // //   console.log(data.status);
            // //   console.log(xhr);

            // //   if (typeof data.xhr !== "undefined") {
            // //     let response = JSON.parse(data.xhr.response);
            // //     console.log(response.product_image_id);
            // //   }

            //   this.files.push(data)
            //   this.$emit('change', this.files);
            // } else if (evt === 'complete') {
            //   console.log('complete');
            //   console.log(data);

            //   if (typeof data.xhr !== "undefined") {
            //     console.log('not undefined');
            //     // let response = JSON.parse(data.xhr.response);
            //     // console.log(response);
            //   }
            } else if (evt === 'removedfile') {
                //   let index = this.files.findIndex(f => f.upload.uuid === data.upload.uuid)
                //   if (index !== -1) {
                //     this.files.splice(index, 1);
                //   }
                //   this.$emit('change', this.files);
            } else if (evt === 'sending') {
                // // csrfトークンをcookieから取得
                // let csrfToken = document.cookie.split('; ').find(row => row.startsWith('XSRF-TOKEN=')).split('=')[1];
                // let csrfTokenDecode = decodeURIComponent(csrfToken);

                // console.log('sending');
                // console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                // console.log(csrfTokenDecode);
                // formData.append("product_id", this.productId);
                // formData.append("_token", "{{ csrf_token() }}");
                // formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                // formData.append("_token", csrfTokenDecode);
            }
          })
        })

        this.defaultImages.forEach(image => {
            // console.log('forEach');
            // console.log(image);

            // let path = '/storage/' + image.image_path;
            // let path = image.image_path;
            let path = image.image_path_by_environment;
            let info = {
                name: '',
                // size: image.file_size ?? image,
                imageId: image.id,
                createdAt: image.created_at,
            }
            this.dropzone.emit("addedfile", info);
            this.dropzone.emit("thumbnail", info, path);
            this.dropzone.emit("complete", info);
        });
      }
    },
    mounted() {
      this.initDropzone();

    //   console.log(this.defaultImages);
    }
  }
</script>
<style>
.dropzone [data-dz-size] strong {
    font-weight: 400;
}
.dropzone .pr-0, .dropzone .px-0 {
    padding-right: 0!important;
}
.dropzone .pl-0, .dropzone .px-0 {
    padding-left: 0!important;
}
.dropzone .row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.col, .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col-auto, .col-lg, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-auto, .col-md, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md-auto, .col-sm, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
.col {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 100%;
}
.col-1, .col-auto {
    -webkit-box-flex: 0;
}
.col-auto {
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    width: auto;
    max-width: 100%;
}
.ml--3, .mx--3 {
    margin-left: -1rem!important;
}
.align-items-center {
    -webkit-box-align: center!important;
    -ms-flex-align: center!important;
    align-items: center!important;
}
.list-group {
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 1rem;
    border-radius: 0.375rem;
}
.list-group-flush {
    border-radius: 0;
}
.list-group-item {
    position: relative;
    display: block;
    padding: 1rem 1rem;
    background-color: #fff;
    border: 1px solid #e9ecef;
}
.list-group-item:first-child {
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
}
.list-group-item:last-child {
    border-bottom-right-radius: inherit;
    border-bottom-left-radius: inherit;
}
.list-group-flush>.list-group-item {
    border-width: 0 0 1px;
}
.list-group-flush>.list-group-item:last-child {
    border-bottom-width: 0;
}

.dz-preview-multiple .list-group-item:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}
.dz-message {
    padding: 5rem 1rem;
    background-color: #fff;
    border: 1px dashed #dee2e6;
    border-radius: 0.375rem;
    text-align: center;
    color: #8898aa;
    -webkit-transition: all .15s ease;
    transition: all .15s ease;
    -webkit-box-ordinal-group: 0;
    -ms-flex-order: -1;
    order: -1;
    cursor: pointer;
    z-index: 999;
}
.dropzone .dropzone-multiple .dz-message {
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.dropzone .thumbnail, .dropzone .thumbnail img {
    border-radius: 0.375rem;
}
.dropzone .thumbnail {
    color: #fff;
    background-color: #adb5bd;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    font-size: 1rem;
    height: 48px;
    width: 48px;
}
.dropzone .thumbnail img {
    width: 100%;
}
.dropzone .rounded {
    border-radius: 0.375rem!important;
}

.dropzone .button {
    display: inline-block;
    font-weight: 600;
    color: #525f7f;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: 0.625rem 1.25rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    -webkit-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
}
.dropzone .btn-danger {
    -webkit-box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
    box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
}
.dropzone .btn-danger, .dropzone .btn-danger:hover {
    color: #fff;
    background-color: #f5365c;
    border-color: #f5365c;
}
.dropzone .btn-group-sm>.btn, .dropzone .btn-sm {
    padding: 0.25rem 0.5rem;
    line-height: 1.5;
    border-radius: 0.25rem;
}
</style>
