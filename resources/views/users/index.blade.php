<select name="level" class="form-control">
    <option value="user"  {{ old('level', $user->level ?? '') == 'user' ? 'selected' : '' }}>User</option>
    <option value="admin" {{ old('level', $user->level ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
</select>