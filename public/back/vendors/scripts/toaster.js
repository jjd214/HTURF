
        window.addEventListener('toast', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                iconColor: event.detail.type === 'success' ? 'green' : 'red',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: event.detail.type,
                title: event.detail.message
            });
        });

        // window.addEventListener('confirm-delete', event => {
        //     Swal.fire({
        //         title: "Are you sure you want to delete " + event.detail.name + " ?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             Livewire.find('{{ $this->getId() }}').deleteProduct(event.detail.id);

        //             Swal.fire({
        //                 title: "Deleted!",
        //                 text: "The product has been deleted.",
        //                 icon: "success"
        //             });
        //         }
        //     });
        // });
