export const users = [
    {id: 1, userName: 'User 1', fullName: 'Fullname 2'},
    {id: 1, userName: 'User 2', fullName: 'Fullname 3'},
];

export const organization = [
    { id: 1, name: 'Organization 1', organization_members: [{ id: 'id1' }, { id: 'id2' } ]},
    { id: 2, name: 'Organization 2', organization_members: [{ id: 'id3' }, { id: 'id4' } ]}
];

export const organizationExpected = [
    { id: 1, name: 'Organization 1', organization_members: [{ id: 'id1' }]},
    { id: 2, name: 'Organization 2', organization_members: [{ id: 'id3' }]}
];

export function getUsersById(id) {
    return users.find(function (d) {
        return d.id == this;
    }, id);
}

export function getOrganizationById(id) {
    return organization.find(function (d) {
        return d.id == this;
    }, id);
}

export function getOrganizationExpectedById(id) {
    return organizationExpected.find(function (d) {
        return d.id == this;
    }, id);
}