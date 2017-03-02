import reducer from '../CurrentOrganization'
import ActionTypes from '../../constants/ActionTypes'
import * as Fixtures from '../../tests/Fixtures'

describe('Current organization reducer tests', () => {
    it('Initial State', () => {
        expect(
            reducer()
        ).toEqual(
            {
                fetching: true,
                organization: null,
                potential_members: []
            }
        );
    }),
    it('Organization fetching', () => {
        expect(
            reducer({}, {type: ActionTypes.CURRENT_ORGANIZATION_FETCHING})
        ).toEqual(
            {
                fetching: true
            }
        )
    }),
    it('Organization received', () => {
        var organizationFixture = Fixtures.getOrganizationById(1);
        expect(
            reducer({}, {type: ActionTypes.CURRENT_ORGANIZATION_RECEIVED, organization: organizationFixture})
        ).toEqual(
            {
                fetching: false, organization: organizationFixture
            }
        )
    }),
    it('Organization member removed', () => {
        var organizationFixture = Fixtures.getOrganizationById(1);
        var expectedOrganizationFixture = Fixtures.getOrganizationExpectedById(1);
        expect(
            reducer({organization: organizationFixture}, {type: ActionTypes.CURRENT_ORGANIZATION_MEMBER_REMOVED, user: {id: 'id2'} })
        ).toEqual(
            {
                fetching: false, organization: expectedOrganizationFixture
            }
        )
    }),
    it('Organization member add', () => {
        var organizationFixture = Fixtures.getOrganizationById(1);
        var expectedOrganizationFixture = Fixtures.getOrganizationExpectedById(1);
        expect(
            reducer({organization: expectedOrganizationFixture}, {type: ActionTypes.CURRENT_ORGANIZATION_MEMBER_REMOVED, user: {id: 'id1'} })
        ).toEqual(
            {
                fetching: false, organization: organizationFixture
            }
        )
    })
});