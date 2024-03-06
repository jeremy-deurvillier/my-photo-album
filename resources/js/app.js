import './bootstrap';

import Alpine from 'alpinejs';

Alpine.store('upload', {
    sendFiles(album, files) {
        files.map((file) => {
            let formData = new FormData();
            formData.append('photos[]', file);

            window.axios.post('/api/uploader/album/' + album, formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                withCredentials: true,

                onUploadProgress: progressEvent => {
                    file.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    console.log('Progression : ', file.progress);
                }
            })
            .then((response) => console.log(response.data))
            .catch((error) => console.error('Error : ', error))
        })
    }
});

window.Alpine = Alpine;

Alpine.start();
