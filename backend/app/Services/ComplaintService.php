<?php

namespace App\Services;

use App\Complaint;
use App\Tag;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ComplaintService
{
    /**
     * Paginated complaints
     * 
     * @param array $data filters for pagination
     */
    public function getPaginatedComplaints(array $data): \Illuminate\Pagination\LengthAwarePaginator
    {
        $validator = Validator::make($data, [
            'per_page' => 'integer|nullable'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['per_page'] = array_key_exists('per_page', $data) && !is_null($data['per_page']) ? $data['per_page'] : 10;

        $result = Complaint::paginate($data['per_page']);

        return $result;
    }

    /**
     * Save or update a complaint
     * 
     * @param array $data data to fill compliant
     * 
     * @return \App\Compliant a compalint instace
     */
    public function saveComplaintData($data, $id = null): Complaint
    {
        $data['status'] = array_key_exists('status', $data) ? $data['status'] : 'pending';
        $data['user_id'] = auth()->user()->id;
        if (!is_null($id)) {
            $data['id'] = $id;
        }

        $validator = Validator::make($data, [
            'id' => 'sometimes|nullable|exists:complaints',
            'status' => 'required_without:id|in:pending,resolved,dismissed',
            'title' => 'required_without:id|string|min:3|max:255',
            'description' => 'nullable|min:3|max:65534',
            'urgent' => 'nullable|boolean',
            'tags' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $complaint = new Complaint();

        if (array_key_exists('id', $data)) {
            $complaint = Complaint::find($data['id']);
        }

        $complaint->fill($data);

        $complaint->save();

        // typicaly this would be handled using a tag service but I am simplifying
        if (array_key_exists('tags', $data)) {
            foreach ($data['tags'] as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                $complaint->tags()->save($tag);
            }
        }

        return $complaint;
    }

    /**
     * Retrieve complaint by id
     * 
     * @param int $id id of complaint
     * 
     * @return ?\App\Complaint
     */
    public function getComplaintById(int $id): ?Complaint
    {
        return Complaint::find($id);
    }

     /**
     * Delete complaint by id
     * 
     * @param int $id id of resource
     * 
     * @return bool is resource deleted or not found
     */
    public function deleteComplaintById(int $id): bool
    {
        return Complaint::destroy($id);
    }
}
