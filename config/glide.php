<?php

return [
    /**
     * The default filesystem disk to read source images from.
     * Set to `null` to use the `public/` directory, or specify
     * a disk name like `public` or `s3` to read from
     * a configured filesystem disk instead.
     */
    'default_source_disk' => null,

    'route' => [
        /**
         * The domain that will be used to generate the Glide URLs.
         */
        'domain' => null,

        /**
         * Whether the generated Glide URLs should be signed.
         * For some browsers this differing query string
         * might prevent browser caching of the image,
         * but major browsers appear to handle fine.
         */
        'signed' => false,
    ],

    'grow' => false,
];
