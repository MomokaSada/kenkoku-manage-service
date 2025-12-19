<?php

return [
    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeは正しいURLではありません。',
    'after'                => ':attributeは:date以降の日付にしてください。',
    'after_or_equal'       => ':attributeは:date以降の日付にしてください。',
    'alpha'                => ':attributeは英字のみにしてください。',
    'alpha_dash'           => ':attributeは英数字とハイフンのみにしてください。',
    'alpha_num'            => ':attributeは英数字のみにしてください。',
    'array'                => ':attributeは配列にしてください。',
    'before'               => ':attributeは:date以前の日付にしてください。',
    'before_or_equal'      => ':attributeは:date以前の日付にしてください。',
    'between'              => [
        'numeric' => ':attributeは:min〜:maxまでにしてください。',
        'file'    => ':attributeは:min〜:max KBまでのファイルにしてください。',
        'string'  => ':attributeは:min〜:max文字にしてください。',
        'array'   => ':attributeは:min〜:max個までにしてください。',
    ],
    'boolean'              => ':attributeはtrueかfalseにしてください。',
    'confirmed'            => ':attributeは確認用項目と一致していません。',
    'date'                 => ':attributeは正しい日付ではありません。',
    'date_equals'          => ':attributeは:dateと同じ日付にしてください。',
    'date_format'          => ':attributeは":format"書式と一致していません。',
    'different'            => ':attributeは:otherと違うものにしてください。',
    'digits'               => ':attributeは:digits桁にしてください。',
    'digits_between'       => ':attributeは:min〜:max桁にしてください。',
    'dimensions'           => ':attributeは無効な画像サイズです。',
    'distinct'             => ':attributeは重複しています。',
    'email'                => ':attributeを正しいメールアドレスにしてください。',
    'ends_with'            => ':attributeは、次のいずれかで終わる必要があります。: :values',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeはファイルにしてください。',
    'filled'               => ':attributeは必須です。',
    'gt'                   => [
        'numeric' => ':attributeは:valueより大きくしてください。',
        'file'    => ':attributeは:value KBより大きくしてください。',
        'string'  => ':attributeは:value文字より多くしてください。',
        'array'   => ':attributeは:value個より多くしてください。',
    ],
    'gte'                  => [
        'numeric' => ':attributeは:value以上にしてください。',
        'file'    => ':attributeは:value KB以上にしてください。',
        'string'  => ':attributeは:value文字以上にしてください。',
        'array'   => ':attributeは:value個以上にしてください。',
    ],
    'image'                => ':attributeは画像にしてください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'in_array'             => ':attributeは:otherのみにしてください。',
    'integer'              => ':attributeは整数にしてください。',
    'ip'                   => ':attributeを正しいIPアドレスにしてください。',
    'ipv4'                 => ':attributeを正しいIPv4アドレスにしてください。',
    'ipv6'                 => ':attributeを正しいIPv6アドレスにしてください。',
    'json'                 => ':attributeを正しいJSON形式にしてください。',
    'lt'                   => [
        'numeric' => ':attributeは:valueより小さくしてください。',
        'file'    => ':attributeは:value KBより小さくしてください。',
        'string'  => ':attributeは:value文字より少なくしてください。',
        'array'   => ':attributeは:value個より少なくしてください。',
    ],
    'lte'                  => [
        'numeric' => ':attributeは:value以下にしてください。',
        'file'    => ':attributeは:value KB以下にしてください。',
        'string'  => ':attributeは:value文字以下にしてください。',
        'array'   => ':attributeは:value個以下にしてください。',
    ],
    'max'                  => [
        'numeric' => ':attributeは:max以下にしてください。',
        'file'    => ':attributeは:max KB以下のファイルにしてください。',
        'string'  => ':attributeは:max文字以下にしてください。',
        'array'   => ':attributeは:max個以下にしてください。',
    ],
    'mimes'                => ':attributeは:valuesタイプのファイルにしてください。',
    'mimetypes'            => ':attributeは:valuesタイプのファイルにしてください。',
    'min'                  => [
        'numeric' => ':attributeは:min以上にしてください。',
        'file'    => ':attributeは:min KB以上のファイルにしてください。',
        'string'  => ':attributeは:min文字以上にしてください。',
        'array'   => ':attributeは:min個以上にしてください。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'not_regex'            => ':attributeの形式は正しくありません。',
    'numeric'              => ':attributeは数字にしてください。',
    'password'             => 'パスワードが間違っています。',
    'present'              => ':attributeは存在している必要があります。',
    'regex'                => ':attributeの形式は正しくありません。',
    'required'             => ':attributeは必須です。',
    'required_if'          => ':otherが:valueの時、:attributeは必須です。',
    'required_unless'      => ':otherが:values以外の時、:attributeは必須です。',
    'required_with'        => ':valuesが存在する時、:attributeは必須です。',
    'required_with_all'    => ':valuesが存在する時、:attributeは必須です。',
    'required_without'     => ':valuesが存在しない時、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない時、:attributeは必須です。',
    'same'                 => ':attributeと:otherは一致していません。',
    'size'                 => [
        'numeric' => ':attributeは:sizeにしてください。',
        'file'    => ':attributeは:size KBにしてください。',
        'string'  => ':attributeは:size文字にしてください。',
        'array'   => ':attributeは:size個にしてください。',
    ],
    'starts_with'          => ':attributeは、次のいずれかで始まる必要があります。: :values',
    'string'               => ':attributeは文字列にしてください。',
    'timezone'             => ':attributeは正しいタイムゾーンをしていしてください。',
    'unique'               => ':attributeは既に存在します。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeは正しいURL書式ではありません。',
    'uuid'                 => ':attributeは正しいUUIDではありません。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
