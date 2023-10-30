<?php

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin\Tests;

trait HttpClient
{
    /**
     * 请求地址
     *
     * @var string
     */
    public $host = 'http://127.0.0.1:8300/api/v1/el_admin';

    /**
     * 请求参数.
     *
     * @var array
     */
    public array $params = [];

    /**
     * 请求头.
     *
     * @var array
     */
    public array $header = [];

    /**
     * 响应体.
     *
     * @var
     */
    public $response;

    /**
     * http响应码
     *
     * @var int
     */
    public $httpCode = 0;

    /**
     * 设置请求头.
     *
     * @param  string  $key
     * @param  string  $value
     * @return $this
     */
    public function withHeader(string $key, string $value)
    {
        $this->header[$key] = $value;

        return $this;
    }

    /**
     * 删除资源.
     *
     * @param  string  $url
     * @param  array  $params
     * @return $this
     */
    public function delete(string $url, array $params = [])
    {
        $this->request($url, 'DELETE', $params);

        return $this;
    }

    /**
     * 创建资源.
     *
     * @param  string  $url
     * @param  array  $params
     * @return $this
     */
    public function post(string $url, array $params = [])
    {
        $this->request($url, 'POST', $params);

        return $this;
    }

    /**
     * 获取资源.
     *
     * @param  string  $url
     * @param  array  $params
     * @return $this
     */
    public function get(string $url, array $params = [])
    {
        $this->request($url, 'GET', $params);

        return $this;
    }

    /**
     * 更新资源.
     *
     * @param  string  $url
     * @param  array  $params
     * @return $this
     */
    public function put(string $url, array $params = [])
    {
        $this->request($url, 'PUT', $params);

        return $this;
    }

    /**
     * 发起请求
     *
     * @param  string  $url
     * @param  string  $method
     * @param  array  $data
     * @return $this
     */
    protected function request(string $url, string $method, array $data = [])
    {
        $url = $this->host.$url;

        $ch = curl_init();

        $method = strtoupper($method);

        if ($method === 'GET' && ! empty($data)) {
            $url .= '?'.http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (! empty($this->header)) {
            $formattedHeaders = [];
            foreach ($this->header as $name => $value) {
                $formattedHeaders[] = $name.': '.$value;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);
        }

        if ($method !== 'GET' && ! empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $response = curl_exec($ch);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // 获取HTTP响应码
        curl_close($ch);

        $this->response = $response;

        return  $this;
    }

    /**
     * 获取响应数据数组.
     *
     * @return array|mixed
     */
    public function json(): array
    {
        try {
            return json_decode($this->response, true);
        } catch (\Exception $e) {
            return [];
        }
    }
}
